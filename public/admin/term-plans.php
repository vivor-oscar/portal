<?php
require_once('include/side-bar.php');
include('../../includes/database.php');

// ensure CSRF token
if (empty($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
// store for use in JS
$csrf_token = $_SESSION['csrf_token'];

// Auto-delete plans older than the current month
$delete_sql = "DELETE FROM term_plans WHERE plan_date < DATE_FORMAT(CURDATE(), '%Y-%m-01')";
$conn->query($delete_sql);

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $plan_date = trim($_POST['plan_date'] ?? '');

    if ($title === '') {
        $errors[] = 'Title is required.';
    }
    if ($plan_date === '') {
        $errors[] = 'Date is required.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('INSERT INTO term_plans (title, description, plan_date) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $title, $description, $plan_date);
        if ($stmt->execute()) {
            $_SESSION['message'] = 'Term plan added successfully.';
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $errors[] = 'Database error: ' . $conn->error;
        }
    }
}

// Handle deletion via GET (simple) - keep consistent with other admin patterns
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $conn->query("DELETE FROM term_plans WHERE id = $id");
    $_SESSION['message'] = 'Term plan deleted.';
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

$results = $conn->query('SELECT * FROM term_plans ORDER BY plan_date ASC');

?>
<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
  <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-6">
    <div class="max-w-5xl mx-auto">
      <div class="flex items-center justify-between mb-6 flex-col sm:flex-row gap-2">
        <h1 class="text-xl sm:text-2xl font-bold">Academic Term Plans</h1>
        <p class="text-xs sm:text-sm text-gray-500">Create and manage term activities and dates</p>
      </div>

      <?php if (!empty($errors)): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
          <ul class="list-disc pl-5">
            <?php foreach ($errors as $e): ?>
              <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <?php if (!empty($_SESSION['message'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
          <?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?>
        </div>
      <?php endif; ?>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-2xl shadow">
          <h2 class="font-semibold mb-3 text-sm sm:text-base">Add / Edit Term Plan</h2>
          <form id="planForm" class="space-y-4">
            <input type="hidden" name="id" id="plan_id" value="0">
            <input type="hidden" name="csrf_token" id="csrf_token" value="<?php echo $csrf_token; ?>">
            <div>
              <label class="block text-xs sm:text-sm mb-1">Title</label>
              <input name="title" id="title" type="text" class="w-full px-2 sm:px-3 py-2 rounded border text-sm sm:text-base truncate" required>
            </div>
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs sm:text-sm mb-1">Start Date</label>
                <input name="start" id="start" type="date" class="w-full px-2 sm:px-3 py-2 rounded border text-sm sm:text-base min-w-0" required>
              </div>
              <div>
                <label class="block text-xs sm:text-sm mb-1">End Date (optional)</label>
                <input name="end" id="end" type="date" class="w-full px-2 sm:px-3 py-2 rounded border text-sm sm:text-base min-w-0">
              </div>
            </div>
            <div>
              <label class="block text-xs sm:text-sm mb-1">Event Type</label>
              <select name="event_type" id="event_type" class="w-full px-2 sm:px-3 py-2 rounded border text-sm sm:text-base min-w-0">
                <option value="general">General</option>
                <option value="exam">Exam</option>
                <option value="holiday">Holiday</option>
                <option value="meeting">Meeting</option>
              </select>
            </div>
            <div>
              <label class="block text-xs sm:text-sm mb-1">Description</label>
              <textarea name="description" id="description" rows="4" class="w-full px-2 sm:px-3 py-2 rounded border text-sm sm:text-base resize-y"></textarea>
            </div>
            <div class="flex justify-between items-center">
              <div class="text-sm text-gray-500" id="formStatus"></div>
              <div class="flex gap-2">
                <button type="button" id="cancelEdit" class="px-2 py-1 sm:px-3 sm:py-2 bg-gray-200 rounded text-xs sm:text-sm hidden min-w-0" aria-label="Cancel">
                  <span class="hidden sm:inline">Cancel</span>
                  <span class="sm:hidden"><i class="fas fa-times"></i></span>
                </button>
                <button type="submit" id="saveBtn" class="bg-blue-600 text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded text-sm sm:text-base hover:bg-blue-700 min-w-0" aria-label="Save">
                  <span class="hidden sm:inline">Save</span>
                  <span class="sm:hidden"><i class="fas fa-check"></i></span>
                </button>
              </div>
            </div>
          </form>
        </div>

        <div class="bg-white dark:bg-gray-800 p-4 sm:p-6 rounded-2xl shadow">
          <h2 class="font-semibold mb-3 text-sm sm:text-base">Upcoming Plans</h2>
          <div id="calendar" class="bg-white dark:bg-gray-900 rounded-lg p-1 sm:p-2 h-72 sm:h-96 overflow-auto"></div>
          <div class="mt-4">
            <p class="text-sm text-gray-500">You can click an event to view details.</p>
          </div>
          <?php if ($results && $results->num_rows > 0): ?>
            <ul class="space-y-3">
              <?php while ($row = $results->fetch_assoc()): ?>
                <li class="flex items-start justify-between bg-gray-50 dark:bg-gray-900 p-2 sm:p-3 rounded">
                  <div>
                    <div class="font-medium text-sm sm:text-base"><?php echo htmlspecialchars($row['title']); ?></div>
                    <div class="text-xs sm:text-xs text-gray-500"><?php echo date('F j, Y', strtotime($row['plan_date'])); ?></div>
                    <div class="mt-1 text-xs sm:text-sm text-gray-700 dark:text-gray-300"><?php echo nl2br(htmlspecialchars($row['description'])); ?></div>
                  </div>
                  <div class="ml-4 flex flex-col items-end gap-2">
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Delete this plan?')" class="text-red-600 hover:underline text-xs sm:text-sm dark:text-red-400" aria-label="Delete">
                      <span class="hidden sm:inline">Delete</span>
                      <span class="sm:hidden"><i class="fas fa-trash"></i></span>
                    </a>
                  </div>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p class="text-sm text-gray-500">No term plans scheduled.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
</div>

<?php include 'modals.php'; ?>
<!-- FullCalendar v5 (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');

    // ensure visible height for FullCalendar
    calendarEl.classList.add('h-96');

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      themeSystem: 'standard',
      events: 'term-plans-data.php',
      eventDisplay: 'block',
      displayEventTime: false,
      // use event colors from the feed (backgroundColor)
      eventDidMount: function(info) {
        // FullCalendar applies colors automatically when the event JSON includes backgroundColor
        // ensure readable text color
        const bg = info.event.backgroundColor || info.event.extendedProps.bgColor || null;
        if (bg) {
          info.el.style.background = bg;
          info.el.style.color = '#fff';
        }
      },
      eventClick: function(info) {
        const ev = info.event;
        // populate modal fields (uses the same IDs as the existing modal)
        document.getElementById('ev_title').textContent = ev.title;
        const startStr = ev.startStr || (ev.start ? ev.start.toISOString().slice(0,10) : '');
        const endStr = ev.endStr || (ev.end ? ev.end.toISOString().slice(0,10) : startStr);
        document.getElementById('ev_date').textContent = startStr + (endStr && endStr !== startStr ? ' — ' + endStr : '');
        document.getElementById('ev_desc').innerHTML = (ev.extendedProps.description || '').replace(/\n/g,'<br>');

        const editBtn = document.getElementById('editEventBtn');
        const deleteBtn = document.getElementById('deleteEventBtn');
        if (editBtn) {
          editBtn.dataset.event = ev.id;
          editBtn.dataset.title = ev.title;
          editBtn.dataset.description = ev.extendedProps.description || '';
          editBtn.dataset.start = startStr;
          editBtn.dataset.end = endStr;
          editBtn.dataset.type = ev.extendedProps.event_type || 'general';
        }
        if (deleteBtn) {
          deleteBtn.dataset.event = ev.id;
        }

        const modal = document.getElementById('eventModal');
        if (modal) modal.classList.remove('hidden');
      }
    });

    // helper: apply Tailwind classes to the FullCalendar toolbar buttons
    function styleFcButtons(){
      const toolbar = calendarEl.querySelector('.fc-toolbar');
      if(!toolbar) return;
      toolbar.querySelectorAll('button').forEach(btn => {
        const text = (btn.textContent || '').trim().toLowerCase();
        // base styles
        btn.classList.add('rounded', 'text-sm', 'px-2', 'py-1');
        // detect and assign colors
        if(text.includes('today')){
          btn.classList.add('bg-blue-600','text-white','hover:bg-blue-700');
        } else if(text.includes('prev') || text.includes('previous') || btn.classList.contains('fc-prev-button')){
          btn.classList.add('bg-gray-100','dark:bg-gray-700','text-gray-700','dark:text-gray-200','hover:bg-gray-200');
        } else if(text.includes('next') || btn.classList.contains('fc-next-button')){
          btn.classList.add('bg-gray-100','dark:bg-gray-700','text-gray-700','dark:text-gray-200','hover:bg-gray-200');
        } else if(text.includes('month') || text.includes('week') || text.includes('day') || btn.classList.contains('fc-dayGridMonth-button') || btn.classList.contains('fc-timeGridWeek-button')){
          btn.classList.add('bg-white','dark:bg-gray-800','text-gray-700','dark:text-gray-200','border','border-gray-200');
        } else {
          // fallback
          btn.classList.add('bg-gray-100','dark:bg-gray-700','text-gray-700','dark:text-gray-200');
        }
      });
    }

    calendar.render();

    // style buttons after render and whenever the calendar navigates
    setTimeout(styleFcButtons, 50);
    // add to datesSet callback so it runs on navigation; support both v5 callback options and event
    try{ calendar.setOption('datesSet', styleFcButtons); }catch(e){}

    // expose refresh method so existing AJAX handlers can call it after create/update/delete
    window.refreshTermCalendar = function(){ calendar.refetchEvents(); };
  });
</script>
 

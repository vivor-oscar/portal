<?php
include('include/side-bar.php');
include('../../includes/database.php');

// Fetch classes and count pending promotions per class
$classes = [];
$cr = $conn->query("SELECT class_name FROM class ORDER BY class_id ASC");
if ($cr) {
    while ($c = $cr->fetch_assoc()) {
        $classes[] = $c['class_name'];
    }
}

$pendingCounts = [];
$pc = $conn->query("SELECT `class`, COUNT(*) AS c FROM students WHERE promotion_status='pending' GROUP BY `class`");
if ($pc) {
    while ($r = $pc->fetch_assoc()) {
        $pendingCounts[$r['class']] = $r['c'];
    }
}

?>

<div class="flex min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 overflow-x-hidden">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Approve Promotions</h1>

        <form id="approve-form">
            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="text-xl font-semibold text-gray-800 dark:text-gray-200">Pending Promotions</div>
                    <div class="text-sm text-gray-500">Review and approve promotions per class or per student.</div>
                </div>
                <div class="flex items-center space-x-2">
                    <input id="class-search" type="search" placeholder="Search classes..." class="px-3 py-2 rounded border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring" />
                    <button id="approve-selected" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">Approve selected (classes)</button>
                </div>
            </div>

            <div class="overflow-hidden shadow rounded-lg border border-gray-300 dark:border-gray-700">
                <table class="min-w-full bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left">Select</th>
                            <th class="px-4 py-3 text-left">Class</th>
                            <th class="px-4 py-3 text-left">Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classes as $cn): ?>
                            <?php $count = intval($pendingCounts[$cn] ?? 0); ?>
                            <tr class="class-row hover:bg-gray-50 dark:hover:bg-gray-700" data-class="<?= htmlspecialchars($cn) ?>">
                                <td class="px-4 py-3">
                                    <input type="checkbox" name="class_names[]" value="<?= htmlspecialchars($cn) ?>" class="w-4 h-4" />
                                </td>
                                <td class="px-4 py-3 cursor-pointer" style="vertical-align: middle;">
                                    <div class="flex items-center space-x-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                        <span class="font-medium text-gray-800 dark:text-gray-200"><?= htmlspecialchars($cn) ?></span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <?php if ($count > 0): ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><?= $count ?></span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">0</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr class="pending-students-row hidden bg-gray-50 dark:bg-gray-800" data-class="<?= htmlspecialchars($cn) ?>">
                                <td colspan="3" class="px-4 py-4">
                                    <div class="pending-students-container" data-class="<?= htmlspecialchars($cn) ?>">
                                        <div class="text-sm text-gray-600">Click the class name to load pending students.</div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-sm text-gray-600 dark:text-gray-300">
                <span id="approve-status" class="ml-3"></span>
            </div>
        </form>
    </main>

    <script>
    (function(){
        var btn = document.getElementById('approve-selected');
        var status = document.getElementById('approve-status');
        var form = document.getElementById('approve-form');
        btn.addEventListener('click', function(e){
            e.preventDefault();
            if (!confirm('Approve promotions for selected classes?')) return;
            var fd = new FormData(form);
            btn.disabled = true; status.textContent = 'Approving...';
            fetch('../../controller/admin_approve_promotions.php', { method: 'POST', body: fd })
                .then(function(r){ return r.json(); })
                .then(function(d){
                    if (d && d.status === 'ok') {
                        status.textContent = 'Processed: ' + d.processed + ' failed: ' + d.failed;
                        setTimeout(function(){ location.reload(); }, 1200);
                    } else {
                        status.textContent = 'Error: ' + (d.message || 'Unknown'); btn.disabled = false;
                    }
                }).catch(function(){ status.textContent = 'Request failed'; btn.disabled = false; });
        });

        // simple class filter
        var search = document.getElementById('class-search');
        if (search) {
            search.addEventListener('input', function(){
                var q = (search.value || '').toLowerCase();
                document.querySelectorAll('.class-row').forEach(function(r){
                    var c = r.getAttribute('data-class') || '';
                    if (c.toLowerCase().indexOf(q) === -1) r.classList.add('hidden'); else r.classList.remove('hidden');
                    var pending = document.querySelector('.pending-students-row[data-class="' + c + '"]');
                    if (pending) { if (c.toLowerCase().indexOf(q) === -1) pending.classList.add('hidden'); }
                });
            });
        }

        // Expand class row to show pending students
        document.querySelectorAll('.class-row').forEach(function(row){
            var className = row.getAttribute('data-class');
            var nameCell = row.querySelector('td:nth-child(2)');
            nameCell.addEventListener('click', function(){
                var pendingRow = document.querySelector('.pending-students-row[data-class="' + className + '"]');
                var container = pendingRow.querySelector('.pending-students-container');
                if (!pendingRow.classList.contains('hidden')) {
                    pendingRow.classList.add('hidden');
                    return;
                }
                // Show and load pending students
                pendingRow.classList.remove('hidden');
                container.innerHTML = '<div class="text-sm text-gray-600">Loading...</div>';
                var fd = new FormData(); fd.append('class_name', className);
                fetch('../../controller/get_pending_promotions.php', { method: 'POST', body: fd })
                    .then(function(r){ return r.json(); })
                    .then(function(d){
                        if (!d || d.status !== 'ok') { container.innerHTML = '<div class="text-sm text-red-600">Failed to load: ' + (d ? d.message : 'Unknown') + '</div>'; return; }
                        var students = d.students || [];
                        if (students.length === 0) { container.innerHTML = '<div class="text-sm text-gray-600">No pending students for this class.</div>'; return; }
                        var html = [];
                        html.push('<div class="overflow-x-auto"><table class="min-w-full text-sm"><thead><tr><th class="px-2 py-1">Select</th><th class="px-2 py-1">ID</th><th class="px-2 py-1">Name</th><th class="px-2 py-1">Target</th></tr></thead><tbody>');
                        students.forEach(function(s){
                            var name = (s.first_name||'') + ' ' + (s.mid_name||'') + ' ' + (s.last_name||'');
                            html.push('<tr class="border-t"><td class="px-2 py-1"><input type="checkbox" class="approve-student-checkbox" value="' + s.student_id + '"></td><td class="px-2 py-1">' + s.student_id + '</td><td class="px-2 py-1">' + name + '</td><td class="px-2 py-1">' + (s.promotion_target||'') + '</td></tr>');
                        });
                        html.push('</tbody></table></div>');
                        html.push('<div class="mt-2"><button class="approve-selected-students bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Approve selected students</button> <span class="approve-status text-sm text-gray-600 ml-2"></span></div>');
                        container.innerHTML = html.join('');

                        // attach handler
                        container.querySelector('.approve-selected-students').addEventListener('click', function(){
                            var boxes = Array.from(container.querySelectorAll('.approve-student-checkbox:checked'));
                            if (boxes.length === 0) { alert('Select at least one student'); return; }
                            if (!confirm('Approve selected students?')) return;
                            var fd2 = new FormData();
                            boxes.forEach(function(b){ fd2.append('student_ids[]', b.value); });
                            var statusSpan = container.querySelector('.approve-status');
                            statusSpan.textContent = 'Approving...';
                            fetch('../../controller/admin_approve_promotions.php', { method: 'POST', body: fd2 })
                                .then(function(r){ return r.json(); })
                                .then(function(resp){
                                    if (resp && resp.status === 'ok') {
                                        statusSpan.textContent = 'Processed: ' + resp.processed + ' failed: ' + resp.failed;
                                        setTimeout(function(){ location.reload(); }, 900);
                                    } else {
                                        statusSpan.textContent = 'Error: ' + (resp ? resp.message : 'Unknown');
                                    }
                                }).catch(function(){ statusSpan.textContent = 'Request failed'; });
                        });
                    }).catch(function(){ container.innerHTML = '<div class="text-sm text-red-600">Request failed</div>'; });
            });
        });
    })();
    </script>
</div>

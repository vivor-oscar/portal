<?php include('include/side-bar.php'); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<div class="flex min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-900 dark:text-gray-100">
  <main class="flex-1 ml-20 md:ml-48 lg:ml-64 pt-20 p-4 md:p-6 lg:p-8 overflow-x-hidden">
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">My Results</h1>
      <p class="text-gray-600 dark:text-gray-400">Download and review your academic results</p>
    </div>

    <div class="max-w-6xl mx-auto">
      <?php
      include('../../includes/database.php');
      $username = $_SESSION['username'];
      $sql = "SELECT * FROM results WHERE student_id=(SELECT student_id FROM students WHERE username='$username') ORDER BY upload_date DESC";
      $result = mysqli_query($conn, $sql);
      $counter = 1;
      
      if ($result->num_rows > 0) {
      ?>
        <!-- Results Grid View for Mobile, Table View for Desktop -->
        <div class="hidden md:block">
          <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
              <table class="w-full">
                <thead>
                  <tr class="bg-gradient-to-r from-blue-600 to-cyan-600 text-white">
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide">#</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide">Filename</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide">Upload Date</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold uppercase tracking-wide">Action</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                  <?php 
                  while ($row = $result->fetch_assoc()) {
                    $file_path = "../../resultroom/" . $row["filename"];
                  ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                      <td class="px-6 py-4 text-sm font-bold text-gray-900 dark:text-white"><?php echo $counter++; ?></td>
                      <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                          <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <i class="fas fa-file-pdf text-blue-600 dark:text-blue-400"></i>
                          </div>
                          <span class="text-sm font-medium text-gray-900 dark:text-white break-all"><?php echo htmlspecialchars($row["filename"]); ?></span>
                        </div>
                      </td>
                      <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400"><?php echo date('M d, Y', strtotime($row["upload_date"])); ?></td>
                      <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                          <button onclick="previewPDF('<?php echo htmlspecialchars($file_path); ?>', '<?php echo htmlspecialchars($row['filename']); ?>')" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-eye"></i>
                            Preview
                          </button>
                          <a href="<?php echo htmlspecialchars($file_path); ?>" download class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            <i class="fas fa-download"></i>
                            Download
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden grid grid-cols-1 gap-4">
          <?php 
          $result = mysqli_query($conn, $sql);
          $counter = 1;
          while ($row = $result->fetch_assoc()) {
            $file_path = "../../resultroom/" . $row["filename"];
          ?>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow duration-200">
              <div class="bg-gradient-to-r from-blue-500 to-cyan-500 h-2"></div>
              <div class="p-6">
                <div class="flex items-start justify-between mb-4">
                  <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                      <i class="fas fa-file-pdf text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                      <p class="text-xs text-gray-500 dark:text-gray-400">Result <?php echo $counter++; ?></p>
                      <p class="text-sm font-bold text-gray-900 dark:text-white break-all"><?php echo htmlspecialchars($row["filename"]); ?></p>
                    </div>
                  </div>
                </div>
                
                <div class="mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                  <div class="flex items-center gap-2 text-sm">
                    <i class="fas fa-calendar-alt text-gray-400"></i>
                    <span class="text-gray-600 dark:text-gray-400">Uploaded on</span>
                    <span class="font-semibold text-gray-900 dark:text-white"><?php echo date('M d, Y', strtotime($row["upload_date"])); ?></span>
                  </div>
                </div>
                
                <div class="flex flex-col gap-2">
                  <button onclick="previewPDF('<?php echo htmlspecialchars($file_path); ?>', '<?php echo htmlspecialchars($row['filename']); ?>')" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-eye"></i>
                    Preview
                  </button>
                  <a href="<?php echo htmlspecialchars($file_path); ?>" download class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-download"></i>
                    Download
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php 
      } else {
      ?>
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-12">
          <div class="flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
              <i class="fas fa-inbox text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Results Yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Your results will appear here once they're uploaded by your school</p>
            <a href="student-dashboard.php" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
              <i class="fas fa-arrow-left"></i>
              Back to Dashboard
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </main>
</div>

<!-- PDF Preview Modal -->
<div id="pdfPreviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 backdrop-blur-sm">
  <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col">
    <!-- Modal Header -->
    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-purple-600 to-blue-600">
      <div>
        <h2 class="text-xl font-bold text-white">Preview Result</h2>
        <p id="previewFileName" class="text-sm text-purple-100 mt-1"></p>
      </div>
      <button onclick="closePDFPreview()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-colors">
        <i class="fas fa-times text-2xl"></i>
      </button>
    </div>

    <!-- PDF Viewer Container -->
    <div class="flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-900 p-4 flex items-center justify-center">
      <div id="pdfContainer" class="bg-white shadow-lg rounded-lg overflow-hidden">
        <canvas id="pdfCanvas" style="display: block; margin: 0 auto; max-width: 100%;"></canvas>
      </div>
      <div id="pdfLoadingSpinner" class="hidden">
        <div class="text-center">
          <div class="inline-block">
            <div class="w-12 h-12 border-4 border-purple-200 border-t-purple-600 rounded-full animate-spin"></div>
          </div>
          <p class="mt-4 text-gray-600 dark:text-gray-400">Loading PDF...</p>
        </div>
      </div>
    </div>

    <!-- Modal Footer with Navigation -->
    <div class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-800 flex items-center justify-between flex-wrap gap-3">
      <div class="flex items-center gap-3">
        <button onclick="previousPage()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white font-medium rounded-lg transition-colors" id="prevBtn" disabled>
          <i class="fas fa-chevron-left"></i>
          Previous
        </button>
        <div class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
          <span class="text-sm font-medium">Page</span>
          <input type="number" id="pageInput" min="1" onchange="goToPage(this.value)" class="w-12 px-2 py-1 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-600 text-center dark:text-white" value="1">
          <span class="text-sm font-medium">of <span id="pageCount">0</span></span>
        </div>
        <button onclick="nextPage()" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors" id="nextBtn">
          <i class="fas fa-chevron-right"></i>
          Next
        </button>
      </div>
      <div class="flex items-center gap-2 flex-wrap">
        <button onclick="zoomOut()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
          <i class="fas fa-search-minus"></i>
          Zoom Out
        </button>
        <button onclick="zoomIn()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-lg transition-colors">
          <i class="fas fa-search-plus"></i>
          Zoom In
        </button>
        <a id="downloadLink" href="#" download class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
          <i class="fas fa-download"></i>
          Download
        </a>
      </div>
    </div>
  </div>
</div>

<script>
  // PDF.js setup
  pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

  let pdfDoc = null;
  let currentPage = 1;
  let scale = 1.5;
  let currentFileName = '';

  // Open PDF preview
  async function previewPDF(filePath, fileName) {
    currentFileName = fileName;
    document.getElementById('pdfPreviewModal').classList.remove('hidden');
    document.getElementById('previewFileName').textContent = 'File: ' + fileName;
    document.getElementById('pdfLoadingSpinner').classList.remove('hidden');
    document.getElementById('pdfContainer').classList.add('hidden');

    try {
      // Fetch the PDF
      const response = await fetch(filePath);
      if (!response.ok) {
        throw new Error('Failed to load PDF');
      }

      const arrayBuffer = await response.arrayBuffer();
      pdfDoc = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;

      // Reset to first page
      currentPage = 1;
      document.getElementById('pageCount').textContent = pdfDoc.numPages;
      document.getElementById('pageInput').max = pdfDoc.numPages;
      document.getElementById('downloadLink').href = filePath;

      document.getElementById('pdfLoadingSpinner').classList.add('hidden');
      document.getElementById('pdfContainer').classList.remove('hidden');
      renderPage(currentPage);
      updateNavigation();
    } catch (error) {
      console.error('Error loading PDF:', error);
      document.getElementById('pdfLoadingSpinner').innerHTML = '<div class="text-center"><p class="text-red-600">Error loading PDF. Please try downloading instead.</p></div>';
    }
  }

  // Render a specific page
  async function renderPage(pageNum) {
    if (!pdfDoc) return;

    try {
      const page = await pdfDoc.getPage(pageNum);
      const viewport = page.getViewport({ scale: scale });
      const canvas = document.getElementById('pdfCanvas');
      const context = canvas.getContext('2d');

      canvas.width = viewport.width;
      canvas.height = viewport.height;

      const renderContext = {
        canvasContext: context,
        viewport: viewport
      };

      await page.render(renderContext).promise;
      document.getElementById('pageInput').value = pageNum;
    } catch (error) {
      console.error('Error rendering page:', error);
    }
  }

  // Navigation functions
  function previousPage() {
    if (currentPage > 1) {
      currentPage--;
      renderPage(currentPage);
      updateNavigation();
    }
  }

  function nextPage() {
    if (pdfDoc && currentPage < pdfDoc.numPages) {
      currentPage++;
      renderPage(currentPage);
      updateNavigation();
    }
  }

  function goToPage(pageNum) {
    const num = parseInt(pageNum);
    if (pdfDoc && num >= 1 && num <= pdfDoc.numPages) {
      currentPage = num;
      renderPage(currentPage);
      updateNavigation();
    }
  }

  function updateNavigation() {
    document.getElementById('prevBtn').disabled = currentPage === 1;
    document.getElementById('nextBtn').disabled = !pdfDoc || currentPage === pdfDoc.numPages;
  }

  // Zoom functions
  function zoomIn() {
    scale += 0.2;
    if (pdfDoc) renderPage(currentPage);
  }

  function zoomOut() {
    if (scale > 0.5) {
      scale -= 0.2;
      if (pdfDoc) renderPage(currentPage);
    }
  }

  // Close preview modal
  function closePDFPreview() {
    document.getElementById('pdfPreviewModal').classList.add('hidden');
    pdfDoc = null;
    currentPage = 1;
    scale = 1.5;
    const canvas = document.getElementById('pdfCanvas');
    canvas.width = 0;
    canvas.height = 0;
  }

  // Close modal when clicking outside
  document.getElementById('pdfPreviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
      closePDFPreview();
    }
  });

  // Keyboard navigation
  document.addEventListener('keydown', function(e) {
    if (document.getElementById('pdfPreviewModal').classList.contains('hidden')) return;
    
    if (e.key === 'ArrowLeft') previousPage();
    if (e.key === 'ArrowRight') nextPage();
    if (e.key === 'Escape') closePDFPreview();
  });
</script>


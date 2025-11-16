const _openBtn = document.getElementById("openmodalBtn");
const __uploadModal = document.getElementById("uploadmodal");
const __closeBtn = document.querySelector(".close");
if (_openBtn && __uploadModal) {
  _openBtn.addEventListener('click', () => { __uploadModal.style.display = 'block'; });
}
if (__closeBtn && __uploadModal) {
  __closeBtn.addEventListener('click', () => { __uploadModal.style.display = 'none'; });
}
if (__uploadModal) {
  window.addEventListener('click', function(event) {
    if (event.target === __uploadModal) __uploadModal.style.display = 'none';
  });
}

// ADD STAFF MODAL
function newStaff(){
  document.getElementById('staffFormModal').classList.remove('hidden')
}


// ADD STUDENT
function newStudent(){
  document.getElementById('studentFormModal').classList.remove('hidden')
}
// ADD SUBJECT
function newSubject(){
  document.getElementById('subjectFormModal').classList.remove('hidden')
}

// ADD CLASS
function newClass(){
  document.getElementById('classFormModal').classList.remove('hidden')
}

// ADD TEST
function newTest(){
  document.getElementById('testFormModal').classList.remove('hidden')
}
//NOTIFICATION MODAL
function openNotificationModal() {
  document.getElementById('modal-form').classList.remove('hidden')
}
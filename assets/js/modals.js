
document.getElementById("openmodalBtn").onclick = function() {
    document.getElementById("uploadmodal").style.display = "block";
  };

  document.querySelector(".close").onclick = function() {
    document.getElementById("uploadmodal").style.display = "none";
  };

  window.onclick = function(event) {
    if (event.target == document.getElementById("uploadmodal")) {
      document.getElementById("uploadmodal").style.display = "none";
    }
  };

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
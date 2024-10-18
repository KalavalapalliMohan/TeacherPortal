
const addStudentBtn = document.getElementById("addStudentBtn");
const popup = document.getElementById("popup");
const overlay = document.getElementById("overlay");
const popupClose = document.getElementById("popupClose");
const updatePopup = document.getElementById("updatePopup");
const updateOverlay = document.getElementById("updateOverlay");
const updatePopupClose = document.getElementById("updatePopupClose");

// Open Add Student Popup
addStudentBtn.addEventListener("click", () => {
  popup.classList.add("show");
  overlay.classList.add("show");
});

// Close Add Student Popup
popupClose.addEventListener("click", () => {
  popup.classList.remove("show");
  overlay.classList.remove("show");
});

overlay.addEventListener("click", () => {
  popup.classList.remove("show");
  overlay.classList.remove("show");
});

// Toggle Dropdown
function toggleDropdown(event) {
  const dropdownContent = event.target.parentElement.querySelector(".dropdown-content");
  dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
}

window.addEventListener("click", function(event) {
  if (!event.target.matches('.fas')) {
    const dropdowns = document.querySelectorAll('.dropdown-content');
    dropdowns.forEach(dropdown => {
      dropdown.style.display = "none";
    });
  }
});

// Open Update Popup
function openUpdatePopup() {
  updatePopup.classList.add("show");
  updateOverlay.classList.add("show");
}

// Close Update Popup
updatePopupClose.addEventListener("click", () => {
  updatePopup.classList.remove("show");
  updateOverlay.classList.remove("show");
});

updateOverlay.addEventListener("click", () => {
  updatePopup.classList.remove("show");
  updateOverlay.classList.remove("show");
});


// Fetch Data into form
function UpdateData(id, name, subject, marks) {
    $("#h_id").val(id);
    $("#s_name").val(name);         
    $("#s_subject").val(subject);  
    $("#s_marks").val(marks);    
}


const DeletePopup = document.getElementById("DeletePopup");
const DeleteOverlay = document.getElementById("DeleteOverlay");
const DeletePopupClose = document.getElementById("DeletePopupClose");
window.addEventListener("click", function(event) {
    if (!event.target.matches('.fas')) {
      const dropdowns = document.querySelectorAll('.dropdown-content');
      dropdowns.forEach(dropdown => {
        dropdown.style.display = "none";
      });
    }
  });
// Open Delete Popup
function openDeletePopup(id) {
    $("#d_id").val(id);
    DeletePopup.classList.add("show");
    DeleteOverlay.classList.add("show");
  }
  
  // Close Delete Popup
  DeletePopupClose.addEventListener("click", () => {
    DeletePopup.classList.remove("show");
    DeleteOverlay.classList.remove("show");
  });
  
  DeleteOverlay.addEventListener("click", () => {
    DeletePopup.classList.remove("show");
    DeleteOverlay.classList.remove("show");
  });
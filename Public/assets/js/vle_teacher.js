document.addEventListener("DOMContentLoaded", function () {
  // --- PART 1: Handles switching the main panels (Schedule, Content, etc.) ---

  const tabs = document.querySelectorAll(".vle-tab");
  const panels = document.querySelectorAll(".vle-panel");

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const targetPanelId = tab.getAttribute("data-panel");
      const targetPanel = document.getElementById(targetPanelId);

      tabs.forEach((t) => t.classList.remove("active"));
      panels.forEach((p) => p.classList.remove("active"));

      tab.classList.add("active");
      if (targetPanel) {
        targetPanel.classList.add("active");
      }
    });
  });

  // --- PART 2: Handles all the popups for content generation ---

  const mainPopup = document.getElementById("popupWindow");
  const documentCreatePopup = document.getElementById("documentPopup");
  const uploadCreatePopup = document.getElementById("UploadPopup");
  const quizCreatePopup = document.getElementById("quizPopup");

  const addContentBtn = document.querySelector(".add-content-btn");

  function openMainPopup() {
    if (mainPopup) mainPopup.style.display = "flex";
  }

  function closeAllPopups() {
    if (mainPopup) mainPopup.style.display = "none";
    if (documentCreatePopup) documentCreatePopup.style.display = "none";
    if (uploadCreatePopup) uploadCreatePopup.style.display = "none";
    if (quizCreatePopup) quizCreatePopup.style.display = "none";
  }

  function openCreatePopup(popupId) {
    closeAllPopups();
    const popupToOpen = document.getElementById(popupId);
    if (popupToOpen) {
      popupToOpen.style.display = "flex";
    }
  }

  if (addContentBtn) {
    addContentBtn.addEventListener("click", openMainPopup);
  }

  const closeButtons = document.querySelectorAll(".popup .close");
  closeButtons.forEach((button) => {
    button.addEventListener("click", closeAllPopups);
  });

  const contentChoiceButtons = document.querySelectorAll("#popupWindow button");
  contentChoiceButtons.forEach((button) => {
    const targetPopupId = button.getAttribute("onclick").match(/'([^']+)'/)[1];
    button.addEventListener("click", () => {
      openCreatePopup(targetPopupId);
    });
  });

  const cancelButtons = document.querySelectorAll(
    '.popup-buttons button[type="button"]'
  );
  cancelButtons.forEach((button) => {
    button.addEventListener("click", closeAllPopups);
  });

  // --- NEW: PART 3: Handles collapsible content sections ---

  const sectionHeaders = document.querySelectorAll(".section-header-button");

  sectionHeaders.forEach((header) => {
    header.addEventListener("click", () => {
      // 1. Find the content body, which is the next element after the header's parent div
      const sectionBody = header
        .closest(".content-section")
        .querySelector(".section-body");

      // 2. Toggle the 'hidden' class to show or hide the content
      if (sectionBody) {
        sectionBody.classList.toggle("hidden");
      }

      // 3. Toggle the 'open' class on the button itself to rotate the arrow
      header.classList.toggle("open");
    });
  });
});

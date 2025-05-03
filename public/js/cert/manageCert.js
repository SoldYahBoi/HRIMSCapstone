/**
 * Birth Certificate Management JavaScript
 * Handles form interactions, dynamic field visibility, and data loading
 */
document.addEventListener("DOMContentLoaded", () => {
    // Elements
    const archiveButtons = document.querySelectorAll(".btn-icon.archive")
    const archiveModal = document.getElementById("archiveCertModal")
    const modalOverlay = document.querySelector(".modal-overlay")
    const modalClose = document.querySelector(".modal-close")
    const cancelArchiveBtn = document.getElementById("cancelArchive")
    const confirmArchiveBtn = document.getElementById("confirmArchive")
    const archiveModalMessage = document.getElementById("archiveModalMessage")
  
    // Current form to submit
    let currentArchiveForm = null
  
    // Navigation between certificate types
    const birthBtn = document.getElementById("birthBtn")
    const deathBtn = document.getElementById("deathBtn")
    const birthSection = document.getElementById("birthSection")
    const deathSection = document.getElementById("deathSection")
  
    if (birthBtn && deathBtn && birthSection) {
      birthBtn.addEventListener("click", () => {
        birthBtn.classList.add("active")
        deathBtn.classList.remove("active")
        birthSection.classList.add("active")
        if (deathSection) deathSection.classList.remove("active")
      })
  
      deathBtn.addEventListener("click", () => {
        deathBtn.classList.add("active")
        birthBtn.classList.remove("active")
        if (deathSection) deathSection.classList.add("active")
        birthSection.classList.remove("active")
      })
    }
  
    // Open modal when archive button is clicked
    if (archiveButtons.length > 0) {
      archiveButtons.forEach((button) => {
        button.addEventListener("click", function (e) {
          e.preventDefault()
  
          // Get certificate details
          const certId = this.getAttribute("data-employee-id")
          const certName = this.getAttribute("data-employee-name")
  
          // Update modal message
          if (archiveModalMessage) {
            archiveModalMessage.textContent = `Are you sure you want to archive ${certName || "this certificate"}?`
          }
  
          // Store the form to submit later
          currentArchiveForm = this.closest("form")
  
          // Show modal with animation
          document.body.classList.add("modal-open")
          if (archiveModal) {
            archiveModal.style.display = "flex"
            archiveModal.classList.add("show")
          }
  
          // Focus on cancel button (better accessibility)
          setTimeout(() => {
            if (cancelArchiveBtn) cancelArchiveBtn.focus()
          }, 100)
        })
      })
    }
  
    // Close modal function
    function closeModal() {
      if (archiveModal) {
        archiveModal.classList.remove("show")
        archiveModal.classList.add("hiding")
  
        // Remove hiding class after animation completes
        setTimeout(() => {
          archiveModal.classList.remove("hiding")
          archiveModal.style.display = "none"
          document.body.classList.remove("modal-open")
        }, 300)
      }
    }
  
    // Close modal when clicking the close button
    if (modalClose) {
      modalClose.addEventListener("click", closeModal)
    }
  
    // Close modal when clicking the cancel button
    if (cancelArchiveBtn) {
      cancelArchiveBtn.addEventListener("click", closeModal)
    }
  
    // Close modal when clicking outside the modal
    if (modalOverlay) {
      modalOverlay.addEventListener("click", closeModal)
    }
  
    // Submit form when confirm button is clicked
    if (confirmArchiveBtn) {
      confirmArchiveBtn.addEventListener("click", function () {
        if (currentArchiveForm) {
          // Add loading state to button
          this.classList.add("loading")
          this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...'
          this.disabled = true
  
          // Submit the form after a short delay to show the loading state
          setTimeout(() => {
            currentArchiveForm.submit()
          }, 500)
        }
      })
    }
  
    // Close modal when pressing Escape key
    document.addEventListener("keydown", (e) => {
      if (e.key === "Escape" && archiveModal && archiveModal.classList.contains("show")) {
        closeModal()
      }
    })
  
    // Trap focus inside modal for accessibility
    if (archiveModal) {
      archiveModal.addEventListener("keydown", (e) => {
        if (e.key === "Tab") {
          const focusableElements = archiveModal.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])',
          )
          const firstElement = focusableElements[0]
          const lastElement = focusableElements[focusableElements.length - 1]
  
          // If shift+tab and focus is on first element, move to last element
          if (e.shiftKey && document.activeElement === firstElement) {
            e.preventDefault()
            lastElement.focus()
          }
          // If tab and focus is on last element, move to first element
          else if (!e.shiftKey && document.activeElement === lastElement) {
            e.preventDefault()
            firstElement.focus()
          }
        }
      })
    }
  
    // Search functionality
    const certSearch = document.getElementById("certSearch")
    if (certSearch) {
      certSearch.addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase()
        const activeSection = document.querySelector(".cert-section.active")
  
        if (activeSection) {
          const tableRows = activeSection.querySelectorAll("table tbody tr")
  
          tableRows.forEach((row) => {
            const text = row.textContent.toLowerCase()
            if (text.includes(searchTerm)) {
              row.style.display = ""
            } else {
              row.style.display = "none"
            }
          })
        }
      })
    }
  
    // Filter functionality
    const certFilter = document.getElementById("certFilter")
    if (certFilter) {
      certFilter.addEventListener("change", function () {
        const filterValue = this.value
        const activeSection = document.querySelector(".cert-section.active")
  
        if (activeSection) {
          const tableRows = activeSection.querySelectorAll("table tbody tr")
  
          // In a real application, you would implement filtering logic based on dates
          // For now, we'll just show a notification
          showNotification(`Filter applied: ${filterValue}`, "info")
        }
      })
    }
  
    // Print certificate
    const printCertButtons = document.querySelectorAll(".print-cert")
    if (printCertButtons.length > 0) {
      printCertButtons.forEach((button) => {
        button.addEventListener("click", function () {
          const certId = this.getAttribute("data-id")
  
          // In a real application, you would redirect to a print view or generate a PDF
          // For now, we'll just show a notification
          showNotification("Preparing certificate for printing...", "info")
  
          // Simulate redirection to print view
          setTimeout(() => {
            window.location.href = `/certificates/${certId}/print`
          }, 1000)
        })
      })
    }
  
    // Success notification handling
    const successMessage = document.querySelector(".success-popup")
    if (successMessage) {
      // Show the notification
      setTimeout(() => {
        successMessage.classList.add("show")
  
        // Create progress bar animation
        const progressBar = document.querySelector(".success-popup-progress-bar")
        if (progressBar) {
          progressBar.style.animation = "progress 5s linear forwards"
        }
  
        // Hide after 5 seconds
        setTimeout(() => {
          successMessage.classList.remove("show")
          setTimeout(() => {
            successMessage.remove()
          }, 300)
        }, 5000)
      }, 300)
  
      // Close button functionality
      const closeBtn = successMessage.querySelector(".success-popup-close")
      if (closeBtn) {
        closeBtn.addEventListener("click", () => {
          successMessage.classList.remove("show")
          setTimeout(() => {
            successMessage.remove()
          }, 300)
        })
      }
    }
  
    // Notification function
    function showNotification(message, type) {
      const notification = document.createElement("div")
      notification.className = `notification notification-${type}`
      notification.innerHTML = `
              <div class="notification-icon">
                  <i class="fas fa-${type === "success" ? "check-circle" : type === "info" ? "info-circle" : type === "warning" ? "exclamation-triangle" : "exclamation-circle"}"></i>
              </div>
              <div class="notification-message">${message}</div>
          `
  
      document.body.appendChild(notification)
  
      // Animate in
      setTimeout(() => {
        notification.classList.add("show")
      }, 10)
  
      // Remove after 3 seconds
      setTimeout(() => {
        notification.classList.remove("show")
        setTimeout(() => {
          notification.remove()
        }, 300)
      }, 3000)
    }
  })
  
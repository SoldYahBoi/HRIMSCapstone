document.addEventListener("DOMContentLoaded", () => {
    // PDF Download functionality
    const downloadPdfButton = document.getElementById("downloadPdf")
  
    if (downloadPdfButton) {
      downloadPdfButton.addEventListener("click", () => {
        // Get the certificate container
        const element = document.getElementById("certificate")
  
        // Get registry number for filename
        const registryNo = document.querySelector(".registry-right .registry-field p").textContent.trim()
        const deceasedName = document.querySelector(".name-fields").textContent.trim().replace(/\s+/g, "_")
        const filename = `Death_Certificate_${registryNo}_${deceasedName}.pdf`
  
        // Configure html2pdf options for legal size paper
        const opt = {
          margin: 10,
          filename: filename,
          image: { type: "jpeg", quality: 0.98 },
          html2canvas: { scale: 2, useCORS: true },
          jsPDF: { unit: "mm", format: "legal", orientation: "portrait" },
        }
  
        // Show loading indicator
        showLoading()
  
        // Generate PDF
        const { jsPDF } = window.jspdf
        const html2pdf = window
          .html2pdf()
          .from(element)
          .set(opt)
          .outputPdf()
          .then(() => {
            // Hide loading indicator after PDF is generated
            hideLoading()
          })
      })
    }
  
    // Loading indicator functions
    function showLoading() {
      // Create loading overlay if it doesn't exist
      if (!document.getElementById("loading-overlay")) {
        const loadingOverlay = document.createElement("div")
        loadingOverlay.id = "loading-overlay"
        loadingOverlay.innerHTML = `
                  <div class="loading-spinner"></div>
                  <p>Generating PDF...</p>
              `
        document.body.appendChild(loadingOverlay)
      } else {
        document.getElementById("loading-overlay").style.display = "flex"
      }
    }
  
    function hideLoading() {
      const loadingOverlay = document.getElementById("loading-overlay")
      if (loadingOverlay) {
        loadingOverlay.style.display = "none"
      }
    }
  
    // Function to handle print button
    const printButton = document.createElement("button")
    printButton.className = "btn btn-secondary"
    printButton.innerHTML = '<i class="fas fa-print" aria-hidden="true"></i> Print Certificate'
    printButton.addEventListener("click", () => {
      window.print()
    })
  
    // Add print button to page actions
    const pageActions = document.querySelector(".page-actions")
    if (pageActions) {
      pageActions.appendChild(printButton)
    }
  
    // Function to format dates in a readable format
    function formatDate(dateString) {
      if (!dateString) return ""
      const date = new Date(dateString)
      return date.toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
      })
    }
  
    // Apply formatted dates where needed
    document.querySelectorAll(".format-date").forEach((element) => {
      const dateString = element.getAttribute("data-date")
      if (dateString) {
        element.textContent = formatDate(dateString)
      }
    })
  })
  
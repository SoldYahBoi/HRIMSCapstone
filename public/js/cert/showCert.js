document.addEventListener("DOMContentLoaded", () => {
    // PDF Download functionality
    const downloadPdfButton = document.getElementById("downloadPdf")
  
    if (downloadPdfButton) {
      downloadPdfButton.addEventListener("click", () => {
        // Get the certificate container
        const element = document.getElementById("certificate")
  
        // Get registry number for filename
        const registryNo = document.querySelector(".registry-right .registry-field p").textContent.trim()
        const childName = document.querySelector(".child-section .name-fields").textContent.trim().replace(/\s+/g, "_")
        const filename = `Birth_Certificate_${registryNo}_${childName}.pdf`
  
        // Configure html2pdf options
        const opt = {
          margin: 10,
          filename: filename,
          image: { type: "jpeg", quality: 0.98 },
          html2canvas: { scale: 2, useCORS: true },
          jsPDF: { unit: "mm", format: "a4", orientation: "portrait" },
        }
  
        // Show loading indicator
        showLoading()
  
        // Generate PDF
        const { jsPDF } = window.jspdf
        const html2pdf = window.html2pdf
  
        html2pdf()
          .from(element)
          .set(opt)
          .save()
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
  
        // Add styles for loading overlay
        const style = document.createElement("style")
        style.textContent = `
                  #loading-overlay {
                      position: fixed;
                      top: 0;
                      left: 0;
                      width: 100%;
                      height: 100%;
                      background-color: rgba(0, 0, 0, 0.7);
                      display: flex;
                      flex-direction: column;
                      justify-content: center;
                      align-items: center;
                      z-index: 9999;
                      color: white;
                  }
                  .loading-spinner {
                      border: 5px solid #f3f3f3;
                      border-top: 5px solid #3498db;
                      border-radius: 50%;
                      width: 50px;
                      height: 50px;
                      animation: spin 2s linear infinite;
                      margin-bottom: 20px;
                  }
                  @keyframes spin {
                      0% { transform: rotate(0deg); }
                      100% { transform: rotate(360deg); }
                  }
              `
        document.head.appendChild(style)
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
  
    // Add print button to page actions
    const pageActions = document.querySelector(".page-actions")
    if (pageActions) {
      pageActions.appendChild(printButton)
    }
  })
  

function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("programModal");
    const programDetails = document.getElementById("programDetails");
    const closeBtn = document.querySelector(".close-modal");

    document.querySelectorAll(".show-program").forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const programId = this.getAttribute("data-id");

            const escapeHTML = (str) => {
                if (!str) return "";
                return String(str)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            };

            fetch(`getProgramDetails.php?id=${programId}`)
                .then(response => response.json())
                .then(data => {
                    let html = `<h3>${escapeHTML(data.name)}</h3>`;
                    for (const [key, value] of Object.entries(data)) {
                        if (key !== "name") {
                            const displayValue = Array.isArray(value) ? value.join(", ") : value;
                            html += `<div class="program-detail">
                                <strong>${escapeHTML(key.replace(/_/g, " "))}:</strong> ${escapeHTML(displayValue)}
                            </div>`;
                        }
                    }
                    programDetails.innerHTML = html;
                    modal.style.display = "flex";
                })
                .catch(error => {
                    console.error("Error fetching program details:", error);
                    programDetails.innerHTML = "<p>Error loading program details</p>";
                    modal.style.display = "flex";
                });
        });
    });

    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
});
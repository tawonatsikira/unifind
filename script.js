/**
 * Unifind Core JavaScript
 */

// --- Navigation ---
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

// --- Tab Switching ---
function switchTab(tabId, element) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });

    // Deactivate all tabs
    document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Show selected content and activate tab
    const target = document.getElementById(tabId);
    if (target) {
        target.classList.add('active');
        if (element) {
            element.classList.add('active');
        }
    }
}

// --- Program Modal ---
const modal = document.getElementById("programModal");
const modalContent = document.getElementById("programDetails");
const closeBtn = document.querySelector(".close-modal");

function escapeHTML(str) {
    if (!str) return "";
    const p = document.createElement("p");
    p.textContent = str;
    return p.innerHTML;
}

async function showProgramDetails(id) {
    if (!modal || !modalContent) return;

    modalContent.innerHTML = '<div class="loading">Loading details...</div>';
    modal.style.display = "flex";

    try {
        const response = await fetch(`getProgramDetails.php?id=${id}`);
        const data = await response.json();

        if (data.error) {
            modalContent.innerHTML = `<div class="error">${escapeHTML(data.error)}</div>`;
            return;
        }

        let fieldsHtml = "";
        if (data.fields && data.fields.length > 0) {
            fieldsHtml = `
                <div class="detail-section">
                    <strong>fields:</strong>
                    <div class="field-list">
                        ${data.fields.map(f => `<span class="field-tag">${escapeHTML(f)}</span>`).join("")}
                    </div>
                </div>
            `;
        }

        modalContent.innerHTML = `
            <div class="program-detail-view">
                <h2>${escapeHTML(data.name)}</h2>
                <div class="detail-section">
                    <strong>description:</strong>
                    <p>${escapeHTML(data.description)}</p>
                </div>
                <div class="detail-section">
                    <strong>duration:</strong> ${escapeHTML(data.duration)}
                </div>
                <div class="detail-section">
                    <strong>faculty:</strong> ${escapeHTML(data.faculty)}
                </div>
                <div class="detail-section">
                    <strong>university:</strong> ${escapeHTML(data.university_name)}
                </div>
                <div class="detail-section">
                    <strong>requirements:</strong>
                    <p>${escapeHTML(data.requirements)}</p>
                </div>
                ${fieldsHtml}
            </div>
        `;
    } catch (error) {
        console.error("Failed to fetch program details:", error);
        modalContent.innerHTML = '<div class="error">Failed to load program details. Please try again later.</div>';
    }
}

// --- Scroll Sync ---
function scrollToFaculty(faculty) {
    const section = document.getElementById('faculty-' + faculty);
    if (section) {
        section.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function initScrollSync() {
    const programList = document.getElementById('programList');
    const facultySelect = document.getElementById('facultySelect');
    if (!programList || !facultySelect) return;

    let ticking = false;
    programList.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const faculties = Array.from(facultySelect.options).map(opt => opt.value);
                let currentFaculty = faculties[0];
                const containerRect = programList.getBoundingClientRect();

                for (const faculty of faculties) {
                    const section = document.getElementById('faculty-' + faculty);
                    if (section) {
                        const rect = section.getBoundingClientRect();
                        if (rect.top <= containerRect.top + 50) {
                            currentFaculty = faculty;
                        } else {
                            break;
                        }
                    }
                }

                if (facultySelect.value !== currentFaculty) {
                    facultySelect.value = currentFaculty;
                }
                ticking = false;
            });
            ticking = true;
        }
    });
}

// --- Event Listeners ---
document.addEventListener('DOMContentLoaded', () => {
    // Modal close
    if (closeBtn) {
        closeBtn.onclick = () => modal.style.display = "none";
    }

    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };

    // Show program details links
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('show-program')) {
            e.preventDefault();
            const id = e.target.getAttribute('data-id');
            showProgramDetails(id);
        }
    });

    // Initialize scroll sync if on university page
    initScrollSync();
});
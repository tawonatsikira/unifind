/**
 * Unifind Core JavaScript - Modern Edition
 */

// --- Navigation ---
function openNav() {
    document.getElementById("mySidenav").style.width = "300px";
    document.body.style.overflow = "hidden"; // Prevent scroll when menu open
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
    document.body.style.overflow = "auto";
}

// --- Tab Switching ---
function switchTab(tabId, element) {
    // Hide all contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });

    // Deactivate all tabs (both pill and old styles)
    document.querySelectorAll('.tab-pill, .tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Show selected content and activate tab
    const target = document.getElementById(tabId);
    if (target) {
        target.classList.add('active');
        if (element) {
            element.classList.add('active');
            // Scroll tab into view on mobile if it's overflowing
            element.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }
}

// --- Program Modal ---
const modal = document.getElementById("programModal");
const modalContent = document.getElementById("programDetails");

function escapeHTML(str) {
    if (!str) return "";
    const p = document.createElement("p");
    p.textContent = str;
    return p.innerHTML;
}

async function showProgramDetails(id) {
    if (!modal || !modalContent) return;

    modalContent.innerHTML = `
        <div style="padding: 2rem; text-align: center;">
            <div class="loading-skeleton" style="height: 40px; width: 80%; margin: 0 auto 1.5rem; border-radius: 8px;"></div>
            <div class="loading-skeleton" style="height: 100px; width: 100%; margin-bottom: 1.5rem; border-radius: 8px;"></div>
            <div class="loading-skeleton" style="height: 20px; width: 60%; margin: 0 auto; border-radius: 8px;"></div>
        </div>
    `;
    modal.style.display = "flex";
    document.body.style.overflow = "hidden";

    try {
        const response = await fetch(`getProgramDetails.php?id=${id}`);
        const data = await response.json();

        if (data.error) {
            modalContent.innerHTML = `<div class="card" style="border-color: var(--accent); color: var(--accent);">${escapeHTML(data.error)}</div>`;
            return;
        }

        let fieldsHtml = "";
        if (data.fields && data.fields.length > 0) {
            fieldsHtml = `
                <div style="margin-top: 2rem;">
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.75rem;">Fields of Study</div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        ${data.fields.map(f => `<span class="badge-modern" style="background: #f1f5f9; color: var(--text-body);">${escapeHTML(f)}</span>`).join("")}
                    </div>
                </div>
            `;
        }

        modalContent.innerHTML = `
            <div class="program-detail-view">
                <span class="badge-modern badge-primary mb-4">Academic Program</span>
                <h2 style="font-size: 2rem; margin-bottom: 1.5rem; line-height: 1.2;">${escapeHTML(data.name)}</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; background: #f8fafc; padding: 1.5rem; border-radius: 12px;">
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800;">Duration</div>
                        <div style="font-weight: 700; color: var(--text-header);">⏱ ${escapeHTML(data.duration)}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); text-transform: uppercase; font-weight: 800;">Faculty</div>
                        <div style="font-weight: 700; color: var(--text-header);">🏢 ${escapeHTML(data.faculty)}</div>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.75rem;">Description</div>
                    <p style="font-size: 1.05rem; line-height: 1.7;">${escapeHTML(data.description)}</p>
                </div>

                <div style="margin-bottom: 2rem;">
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.75rem;">Admission Requirements</div>
                    <div class="card" style="background: #fff; border-style: dashed; border-width: 2px;">
                        <p style="font-size: 0.95rem;">${escapeHTML(data.requirements)}</p>
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-bottom: 0.75rem;">University</div>
                    <a href="ViewUniversity.php?id=${data.university_id}" style="font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                        ${escapeHTML(data.university_name)} &rarr;
                    </a>
                </div>

                ${fieldsHtml}
                
                <div style="margin-top: 3rem; text-align: center;">
                    <button onclick="document.getElementById('programModal').style.display='none'; document.body.style.overflow='auto';" class="search-btn-modern" style="width: 100%; height: 50px;">Close Details</button>
                </div>
            </div>
        `;
    } catch (error) {
        console.error("Failed to fetch program details:", error);
        modalContent.innerHTML = '<div class="card" style="color: var(--accent);">Failed to load program details. Please try again later.</div>';
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
                        if (rect.top <= containerRect.top + 100) {
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
    // Modal close on background click
    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
            document.body.style.overflow = "auto";
        }
    };

    // Show program details links
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('.show-program');
        if (trigger) {
            e.preventDefault();
            const id = trigger.getAttribute('data-id');
            showProgramDetails(id);
        }
    });

    // Initialize scroll sync if on university page
    initScrollSync();

    // Add scroll listener for nav header transparency
    const nav = document.querySelector('.nav-header');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) {
                nav.style.boxShadow = 'var(--shadow-md)';
            } else {
                nav.style.boxShadow = 'none';
            }
        });
    }
});
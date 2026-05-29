document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll('.filter input[type="checkbox"]');
    const programmes = document.querySelectorAll('.programme');
    const searchBar = document.getElementById("search-bar");

    function updateProgrammeVisibility() {
        const selectedLevels = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        const searchTerm = searchBar.value.toLowerCase().trim();

        programmes.forEach(prog => {
            const programmeName = prog.querySelector("h3").textContent.toLowerCase();
            const matchesLevel = selectedLevels.includes(prog.dataset.level);
            const matchesSearch = programmeName.includes(searchTerm);
            prog.style.display = (matchesLevel && matchesSearch) ? "block" : "none";
        });
    }

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", updateProgrammeVisibility);
    });

    searchBar.addEventListener("input", updateProgrammeVisibility);

    updateProgrammeVisibility();
});

    
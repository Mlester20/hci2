function toggleCheckbox(nextCheckboxId, isChecked) {
    const currentCheckbox = event.target;
    const nextCheckbox = document.getElementById(nextCheckboxId);
    const currentRow = currentCheckbox.closest('tr');
    
    // Identify which day is being selected
    const checkboxId = currentCheckbox.id;
    const days = ['check_m_', 'check_t_', 'check_w_', 'check_th_', 'check_f_'];
    const selectedDayIndex = days.findIndex(day => checkboxId.startsWith(day));

    if (isChecked) {
        // Disable other checkboxes in the same day for this time
        const allDayCheckboxes = document.querySelectorAll(`[id^="${days[selectedDayIndex]}"]`);
        allDayCheckboxes.forEach(cb => {
            if (cb !== currentCheckbox) {
                cb.disabled = true;
                cb.checked = false;
            }
        });

        // Disable checkboxes in the next day
        if (selectedDayIndex < days.length - 1) {
            const nextDayCheckboxes = document.querySelectorAll(`[id^="${days[selectedDayIndex + 1]}"]`);
            nextDayCheckboxes.forEach(cb => {
                cb.disabled = true;
                cb.checked = false;
            });
        }
    } else {
        // Re-enable all checkboxes when unchecked
        const allTableCheckboxes = document.querySelectorAll('input[type="checkbox"]');
        allTableCheckboxes.forEach(cb => {
            cb.disabled = false;
        });
    }
}
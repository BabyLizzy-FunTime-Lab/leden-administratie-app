import './bootstrap';

window.toggleReadOnlyFamilyMemberForm = function () {
    // This reactivates form elements that are disabled or readOnly.
    document.querySelectorAll('.read-only-toggle').forEach(el => {
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
            el.readOnly = !el.readOnly;
        } else if (el.tagName === 'SELECT') {
            el.disabled = !el.disabled;
        }
    });

    // This hides or exposes the delete and save button.
    let readOnlyControls = document.getElementById('read-only-controls');
    let readOnlyToggleButton = document.getElementById('read-only-toggle-button');

    if(readOnlyControls.classList.contains('d-none')) {
        readOnlyControls.classList.remove('d-none');
        readOnlyControls.classList.add('d-flex', 'justify-content-between');
        readOnlyToggleButton.classList.add('d-none');
    } else {
        readOnlyControls.classList.remove('d-flex', 'justify-content-between');
        readOnlyControls.classList.add('d-none');
        readOnlyToggleButton.classList.remove('d-none');
    }
}

window.toggleReadOnlyFamilyForm = function () {
    // This reactivates form elements that are disabled or readOnly.
    document.querySelectorAll('.read-only-toggle-family-form').forEach(el => {
        if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
            el.readOnly = !el.readOnly;
        } else if (el.tagName === 'SELECT') {
            el.disabled = !el.disabled;
        }
    });

    let readOnlyControlsContainer = document.getElementById('read-only-controls-container');
    let readOnlyToggleButtonContainer =
        document.getElementById('read-only-toggle-button-container');

    if(readOnlyToggleButtonContainer.classList.contains('d-none')) {
        readOnlyToggleButtonContainer.classList.remove('d-none');
        readOnlyControlsContainer.classList.add('d-none');
    } else {
        readOnlyToggleButtonContainer.classList.add('d-none');
        readOnlyControlsContainer.classList.remove('d-none');
        readOnlyControlsContainer.classList.add('d-flex', 'justify-content-between');
    }
}

const editBtn = document.getElementById('edit-btn');
const cancelBtn = document.getElementById('cancel-btn');
const viewMode = document.getElementById('view-mode');
const editMode = document.getElementById('edit-mode');

const toggleDisplay = () => {
    viewMode.classList.toggle('hidden');
    editMode.classList.toggle('hidden');
};

if (editBtn) {
    editBtn.addEventListener('click', toggleDisplay);
}

if (cancelBtn) {
    cancelBtn.addEventListener('click', toggleDisplay);
}
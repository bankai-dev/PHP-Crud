// Drag and drop
$(document).ready(function () {
  function handleDragStart(event) {
    event.dataTransfer.setData('text/plain', event.target.dataset.index);
    event.currentTarget.style.opacity = '0.4';
  }

  function handleDragEnd(event) {
    event.currentTarget.style.opacity = '1';
  }

  function handleDrop(event) {
    event.preventDefault();
    const data = event.dataTransfer.getData('text/plain');
    const draggedIndex = parseInt(data, 10);
    const dropIndex = parseInt(event.currentTarget.dataset.index, 10);
    if (!isNaN(draggedIndex) && !isNaN(dropIndex) && draggedIndex !== dropIndex) {
      const rows = document.querySelectorAll('.draggable-row');
      const draggedRow = document.querySelector(`[data-index="${draggedIndex}"]`);
      const dropRow = document.querySelector(`[data-index="${dropIndex}"]`);
      if (draggedRow && dropRow) {
        const parent = event.currentTarget.parentElement;
        if (draggedIndex < dropIndex) {
          parent.insertBefore(draggedRow, dropRow.nextSibling);
        } else {
          parent.insertBefore(draggedRow, dropRow);
        }
      }
    }
  }

  function handleDragOver(event) {
    event.preventDefault();
  }

  const rows = document.querySelectorAll('.draggable-row');

  for (const row of rows) {
    row.addEventListener('dragstart', handleDragStart);
    row.addEventListener('dragend', handleDragEnd);
    row.addEventListener('dragover', handleDragOver);
    row.addEventListener('drop', handleDrop);
  }
});

// Modal de Confirmação de exclusão
document.addEventListener('DOMContentLoaded', function () {
  const deleteButtons = document.querySelectorAll('.delete-task-button');
  const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
  const confirmDeleteButton = document.getElementById('confirmDeleteButton');

  let taskIdToDelete;

  deleteButtons.forEach(button => {
    button.addEventListener('click', function (event) {
      taskIdToDelete = event.target.dataset.taskId;
      deleteConfirmationModal.show();
      console.log("teste")
    });
  });

  confirmDeleteButton.addEventListener('click', function () {
    if (taskIdToDelete) {
      window.location.href = '../src/delete.php?id=' + taskIdToDelete;
    }
  });
});

const editButtons = document.querySelectorAll(".edit-btn");
editButtons.forEach((btn) => {
  btn.addEventListener("click", function () {
    const taskId = this.getAttribute("data-id");
    const taskTitle = this.getAttribute("data-title");
    const taskDescription = this.getAttribute("data-description");

    document.getElementById("editTaskId").value = taskId;
    document.getElementById("editTaskTitle").value = taskTitle;
    document.getElementById("editTaskDescription").value = taskDescription;

    const editModal = new bootstrap.Modal(
      document.getElementById("editTaskModal")
    );
    editModal.show();
  });
});

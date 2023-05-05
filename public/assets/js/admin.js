document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebar-toggle");
  const opened = localStorage.getItem("opened") === "true" ?? true;
  if (opened) {
    sidebar.classList.add("opened");
  }
  if (sidebar && sidebarToggle) {
    sidebarToggle.onclick = () => {
      sidebar.classList.toggle("opened");
      localStorage.setItem("opened", (sidebar.classList.contains("opened").toString()));
    };
  }
});

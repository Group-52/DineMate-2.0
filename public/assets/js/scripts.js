document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebar-toggle");
  if (sidebar && sidebarToggle) {
    const sidebarState = localStorage.getItem("sidebarState") || "open";
    sidebar.classList.add(sidebarState);
    sidebarToggle.onclick = () => {
      sidebar.classList.toggle("open");
      sidebar.classList.toggle("closed");
      localStorage.setItem(
        "sidebarState",
        sidebar.classList.contains("open") ? "open" : "closed"
      );
    };
  }
});

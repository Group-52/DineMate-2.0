document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const sidebarOpen = document.getElementById("sidebar-open");
  const sidebarClose = document.getElementById("sidebar-close");
  if (sidebar && sidebarOpen && sidebarClose) {
    const sidebarState = localStorage.getItem("sidebarState") || "closed";
    sidebar.classList.add(sidebarState);
    sidebarOpen.onclick = () => {
      sidebar.classList.add("open");
      sidebar.classList.remove("closed");
      localStorage.setItem(
        "sidebarState",
        sidebar.classList.contains("open") ? "open" : "closed"
      );
    };
    sidebarClose.onclick = () => {
      sidebar.classList.add("closed");
      sidebar.classList.remove("open");
      localStorage.setItem(
        "sidebarState",
        sidebar.classList.contains("open") ? "open" : "closed"
      );
    };
  }
});

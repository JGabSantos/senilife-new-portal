if (localStorage.getItem("theme-mode") == undefined) {
  const prefersDarkTheme =
    window.matchMedia("(prefers-color-scheme: dark)").matches ||
    window.navigator.prefersColorScheme === "dark";

  if (prefersDarkTheme) {
    document.querySelector("html").setAttribute("theme-mode", "dark");
  } else {
    document.querySelector("html").setAttribute("theme-mode", "light");
  }
} else {
  document
    .querySelector("html")
    .setAttribute("theme-mode", localStorage.getItem("theme-mode"));
}

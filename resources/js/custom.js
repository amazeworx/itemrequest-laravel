function isStandalone() {
  return (
    !!navigator.standalone ||
    window.matchMedia("(display-mode: standalone)").matches
  )
}

// Depends on bowser but wouldn't be hard to use a
// different approach to identifying that we're running on Android
function exitsOnBack() {
  return isStandalone() && browserInfo.os.name === "Android"
}

// Everything below has to run at page start, probably onLoad

if (exitsOnBack()) handleBackEvents()

function handleBackEvents() {
  window.history.pushState({}, "")

  window.addEventListener("popstate", () => {
    //TODO: Optionally show a "Press back again to exit" tooltip
    setTimeout(() => {
      window.history.pushState({}, "")
      //TODO: Optionally hide tooltip
    }, 2000)
  })
}

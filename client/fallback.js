if ("noModule" in HTMLScriptElement.prototype) {
    // It's supported => don't replace
} else {
    window.addEventListener("DOMContentLoaded", function () {
        var list = document.querySelectorAll("modular-behaviour");
        for (var i = 0; i < list.length; i++) {
            var el = list[i];
            el.innerHTML = "This widget is not supported by your browser";
            el.style.cssText =
                "border:1px solid red;padding:1em;color:red;display:block;text-align:center;";
        }
    });
}

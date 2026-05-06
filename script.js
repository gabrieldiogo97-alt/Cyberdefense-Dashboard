const terminal = document.getElementById("terminal");
const input = document.getElementById("input");

function print(text) {
    const line = document.createElement("div");
    line.textContent = text;
    terminal.appendChild(line);
}

input.focus();

input.addEventListener("keydown", function(e) {

    if (e.key === "Enter") {

        const command = input.value.trim();

        if (command === "") return;

        print("gabriel@server:~$ " + command);

        if (command === "clear") {
            terminal.innerHTML = "";
            input.value = "";
            return;
        }

        if (command === "help") {
            print("Commands: help, clear");
            input.value = "";
            return;
        }

        fetch("command.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "cmd=" + encodeURIComponent(command)
        })
        .then(res => res.text())
        .then(data => {
            print(data);

if (data.includes("not allowed")) {

    const alert = document.createElement("div");

    alert.innerHTML = "🚨 ALERT: Suspicious command detected";

    alert.style.color = "red";
    alert.style.fontWeight = "bold";

    terminal.appendChild(alert);

}
        });

        input.value = "";
    }

});

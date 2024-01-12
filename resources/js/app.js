import "./bootstrap";
import axios from "axios";

const form = document.getElementById("form");
const inputMessage = document.getElementById("input-message");
const listMessage = document.getElementById("list-messages");

form.addEventListener("submit", function (event) {
    event.preventDefault();
    const userInput = inputMessage.value;

    axios.post("/chat-message", {
        message: userInput,
    });

    inputMessage.value = "";
});

const channel = Echo.channel("public.chat.channel.1");

channel
    .subscribed(() => {
        console.log("subscribed...");
    })
    .listen(".chat-message", (event) => {
        console.log("chat-message event");
        console.log(event);

        const message = event.message;

        const li = document.createElement("li");
        li.textContent = message;
        listMessage.append(li);
    });

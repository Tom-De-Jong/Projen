let answers = [];

function startQuestions() {
    document.querySelector(".card").style.display = "none"
    document.querySelector(".questionCard").style.display = "flex"
}

function nextQuestion(that) {
    let questionId = that.parentNode.id;
    let question = that.parentNode.children[0].innerHTML


    answers.push({
        "question": question,
        "answer": that.parentNode.children[1].value
    });


    switch (that.parentNode.id) {
        case "q1":
            document.querySelector("#q1").style.display = "none"
            document.querySelector("#q2").style.display = "flex"
            break;
        case "q2":
            document.querySelector("#q2").style.display = "none"
            document.querySelector("#q3").style.display = "flex"
            break;
        case "q3":
            document.querySelector("#q3").style.display = "none"
            document.querySelector("#q4").style.display = "flex"
            break;
        case "q4":
            document.querySelector("#q4").style.display = "none"
            document.querySelector("#q5").style.display = "flex"
            break;
        case "q5":
            document.querySelector("#q5").style.display = "none"
            document.querySelector("#q6").style.display = "flex"
            break;
        case "q6":
            document.querySelector("#q6").style.display = "none"
            document.querySelector("#loading").style.display = "flex"
            fetch("https://cdn.tomwebsites.nl/projen/index.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    answers: answers
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data.choices[0].message.content);

                    document.querySelector(".contentHolder").style.display = "none";
                    document.querySelector(".answerCard").style.display = "flex";
                    document.querySelector(".AIanswer").innerHTML = data.choices[0].message.content;
                })
                .catch(error => {
                    console.error(error);
                });

            break;

        default:
            break;
    }
}
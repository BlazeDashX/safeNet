document.addEventListener("DOMContentLoaded", function() {

    // --- Quiz Form ---
    const quizForm = document.getElementById('quizForm');

    if (quizForm) {
        quizForm.onsubmit = function(e) {
            e.preventDefault(); // Prevent reload

            let score = 0;
            const total = 2; // Total questions

            // Get selected answers
            const q1 = document.querySelector('input[name="q1"]:checked');
            const q2 = document.querySelector('input[name="q2"]:checked');

            if (!q1 || !q2) {
                alert("Please answer all questions first!"); // Validation
                return;
            }

            // Check answers
            if (q1.value === 'correct') score++;
            if (q2.value === 'correct') score++;

            // Display result
            const resultBox = document.getElementById('quizResult');
            resultBox.textContent = `You scored ${score} out of ${total}!`;

            // Feedback color
            if (score === total) {
                resultBox.style.color = "green";
                resultBox.textContent += " 🎉 Excellent work!";
            } else {
                resultBox.style.color = "orange";
                resultBox.textContent += " Keep learning!";
            }
        };
    }
});

const compatibility = {
    'O': ['O', 'A', 'B', 'AB'],
    'A': ['A', 'AB'],
    'B': ['B', 'AB'],
    'AB': ['AB']
};

const canvas = document.getElementById("flowCanvas");
const ctx = canvas.getContext("2d");

function resizeCanvas() {
    canvas.width = document.querySelector(".transfusion-chart").clientWidth;
    canvas.height = document.querySelector(".transfusion-chart").clientHeight;
}

window.addEventListener("resize", resizeCanvas);
resizeCanvas();

function showFlow(type) {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    const donorBag = document.querySelector(`.blood-bag[data-type="${type}"]`);
    const recipientTypes = compatibility[type];
    
    recipientTypes.forEach(recipientType => {
        const recipient = document.querySelector(`.blood-bag.recipient[data-type="${recipientType}"]`);
        drawFlowLine(donorBag, recipient);
    });
}

function drawFlowLine(startElem, endElem) {
    const start = startElem.getBoundingClientRect();
    const end = endElem.getBoundingClientRect();

    const chartOffset = document.querySelector(".transfusion-chart").getBoundingClientRect();
    
    const startX = start.left + start.width / 2 - chartOffset.left;
    const startY = start.top + start.height / 2 - chartOffset.top;
    const endX = end.left + end.width / 2 - chartOffset.left;
    const endY = end.top + end.height / 2 - chartOffset.top;

    ctx.beginPath();
    ctx.moveTo(startX, startY);
    ctx.lineTo(startX + (endX - startX) / 2, startY);
    ctx.lineTo(startX + (endX - startX) / 2, endY);
    ctx.lineTo(endX, endY);
    ctx.strokeStyle = "#e74c3c";
    ctx.lineWidth = 3;
    ctx.stroke();
}

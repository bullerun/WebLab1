var button = document.getElementById('submitButton')
button.onclick = handleButtonClick;
table = document.getElementById("result");

function handleButtonClick() {
    let flag = true;
    let checkbox = document.querySelectorAll('input[type=checkbox]');
    let countCheckBox = 0;
    for (let i = 0; i < checkbox.length; i++) {
        let check = checkbox[i];
        if (check.checked) {
            var x = check.value;
            countCheckBox++;
        }
    }

    if (countCheckBox === 0) {
        flag = false;
        alert("Put one check mark for the x coordinate")
    }
    if (countCheckBox > 1) {
        flag = false;
        alert("Put only one check mark for the x coordinate")
    }
    let coordinatesY = document.getElementById("inputText").value;
    if (coordinatesY !== '') {
        let checkY = Number(coordinatesY)
        if (!isNaN(checkY)) {
            if (3 > checkY && checkY > -5) {
                var y = checkY;
            } else {
                flag = false;
                alert("y belongs to (-5; 3)")
                //Введите только цифру в промежутке от (-5;3)
            }
        } else {
            flag = false;
            alert("y should contain only digits")
            // игрик должен содержать только цифры
        }

    } else {
        flag = false;
        alert("y cannot be empty")
        // игрик не может быть пустым
    }
    let radius = document.querySelectorAll('input[type=radio]');
    for (let i = 0; i < radius.length; i++) {
        if (radius[i].checked) {
            var r = radius[i].value
            break
        }
    }
    if (flag) {
        send(x, y, r);
    }
}

function send(x, y, r) {
    console.log("SENDING");
    $.ajax({
        type: "POST",
        url: "/../php/server.php",
        dataType: "html",
        data: "x=" + x +
            "&y=" + y +
            "&r=" + r +
            "&time_zone_offset=" + new Date().getTimezoneOffset(),

        success: function (data) {
            table.innerHTML += data
        }
    });
}
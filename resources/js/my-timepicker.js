var moment = require('moment');
const myTimePicker = {};
/*
 *開始時刻と終了時刻を受け取り、時間の配列を生成する
 */
myTimePicker.initTime = (element, start, end, interval) => {
    let startTime = moment(start, 'HH:mm');
    let endTime = moment(end, 'HH:mm');
    let timeArr = [];
    while (startTime <= endTime) {
        timeArr.push(startTime.format("HH:mm"));
        startTime = startTime.add(interval, 'minutes');
    }

    let optionTags = [];
    for (i = 0; i < timeArr.length; i++) {
        optionTags.push('<option>' + timeArr[i] + '</option>');
    }
    element.append(optionTags);

    if(element.data("old")){
        element.val(element.data("old"));
    }
}

window.myTimePicker = myTimePicker;
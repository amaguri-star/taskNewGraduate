'use strict'

const date = new Date()
const year = date.getFullYear()
const month = date.getMonth() + 1
const firstDate = new Date(year, month - 1, 1)

// 曜日データ （０：日, １：月, ２：火, ３：水, ４：木、５：金、６：土 ）
const firstDay = firstDate.getDay()

// new Dateの第二引数に来月の月の値、第三引数に０を渡してあげることで、来月の初日の1日前、
// つまり、今月の最終日を取得できる。
const lastDate = new Date(year, month, 0)

// 最終日の日にちを取得
const lastDayCount = lastDate.getDate()

let dayCount = 1
let createHtml = ''

createHtml = '<h1>' + year + '/' + month + '</h1>'
createHtml += '<table>' + '<tr>'

const weeks = ['日', '月', '火', '水', '木', '金', '土']
for (let i = 0; i <= weeks.length-1; i++) {
    createHtml += '<td>' + weeks[i] + '</td>'
}
createHtml += '</tr>'

for (let i = 0; i < 6; i++) {
    createHtml += '<tr>'
    for (let j = 0; j < 7; j++) {
        if (i == 0 && j < firstDay) {
            createHtml += '<td></td>'
        } else if (dayCount > lastDayCount) {
            createHtml += '<td></td>'
        } else {
            createHtml += '<td>' + dayCount + '</td>'
            dayCount++
        }
    }
    createHtml += '</tr>'
}

createHtml += '</table>'
document.querySelector('#calendar').innerHTML = createHtml
console.log(createHtml)
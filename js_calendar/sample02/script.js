const date = new Date()
const monthDays = document.querySelector('.days')
const months = [
    "１月",
    "２月",
    "３月",
    "４月",
    "５月",
    "６月",
    "７月",
    "８月",
    "９月",
    "１０月",
    "１１月",
    "１２月"
]

function renderCalendar() {

    const year = date.getFullYear()
    const month = date.getMonth()
    const ondate = date.getDate()

    const prevLastDay = new Date(year, month, 0).getDate()
    const lastDay = new Date(year, month + 1, 0).getDate()
    const firstDayIndex = new Date(year, month, 1).getDay()
    const lastDayIndex = new Date(year, month + 1, 0).getDay()
    const nextDays = 7 - lastDayIndex - 1

    document.querySelector('.date h1').innerHTML = months[month]
    document.querySelector('.date p').innerHTML = date.toLocaleDateString('ja')

    let days = ""

    for (let i = firstDayIndex; i > 0; i--) {
        days += `<div class="prev-date">${prevLastDay - i + 1}</div>`
    }

    for (let i = 1; i <= lastDay; i++) {
        if (i === ondate && month === new Date().getMonth() && year == new Date().getFullYear()) {
            days += `<div class="today">${i}</div>`
        } else {
            days += `<div>${i}</div>`
        }
    }

    for (let i = 1; i <= nextDays; i++) {
        days += `<div class="next-date">${i}</div>`
    }

    monthDays.innerHTML = days;
}


document.querySelector('.prev').addEventListener('click', () => {
    date.setMonth(date.getMonth() - 1)
    renderCalendar()
})

document.querySelector('.next').addEventListener('click', () => {
    date.setMonth(date.getMonth() + 1)
    renderCalendar()
})

renderCalendar()
<?php require_once dirname(__FILE__).'/../views/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFT-PB | Future Dates Calendar</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            font-weight: 700;
            font-size: 2.5rem;
            margin-top: 20px;
        }

        .tabs {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .tab {
            padding: 12px 24px;
            margin: 0 5px;
            cursor: pointer;
            background-color: #e3eaf0;
            border-radius: 20px;
            font-size: 1.2rem;
            transition: background-color 0.3s;
        }

        .tab.active {
            background-color: #3598db;
            color: white;
        }

        .year-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .month-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .month-header {
            background-color: #4c9fd1;
            color: white;
            padding: 15px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border-radius: 15px 15px 0 0;
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .calendar-table th, .calendar-table td {
            padding: 12px;
            text-align: center;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .calendar-table th {
            background-color: #007bff;
            color: white;
        }

        .calendar-table td {
            background-color: #f9f9f9;
        }

        .calendar-table td.saturday {
            background-color: #ffebcd; /* Light color for Saturdays */
        }

        .calendar-table td.sunday {
            background-color: #ffcccc; /* Light color for Sundays */
        }

        .date-circle {
            display: inline-block;
            width: 35px;
            height: 35px;
            line-height: 35px;
            border-radius: 50%;
            background-color: #f1f6fa;
            color: #2c3e50;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
        }

        .calendar-table td:hover .date-circle {
            background-color: #007bff;
            color: white;
            transform: scale(1.2);
            cursor: pointer;
        }

        .disabled {
            pointer-events: none;
            opacity: 0.6;
        }
    </style>
</head>
<body>

<h1>Future Dates Calendar</h1>

<div class="tabs" id="yearTabs">
    <div class="tab" data-year="2024">2024</div>
    <div class="tab" data-year="2025">2025</div>
</div>

<div class="year-container" id="yearCalendar"></div>

<script>
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const today = new Date();

    function generateYearCalendar(year) {
        const yearContainer = document.getElementById('yearCalendar');
        yearContainer.innerHTML = '';

        const startMonth = year === today.getFullYear() ? today.getMonth() : 0;

        for (let month = startMonth; month < 12; month++) {
            const monthDiv = document.createElement('div');
            monthDiv.className = 'month-container';
            monthDiv.innerHTML = `<div class="month-header">${monthNames[month]}</div>`;

            const calendarTable = document.createElement('table');
            calendarTable.className = 'calendar-table';

            let headerRow = '<tr>';
            for (let i = 0; i < 7; i++) headerRow += `<th>${['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'][i]}</th>`;
            headerRow += '</tr>';
            calendarTable.innerHTML = headerRow;

            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const firstDay = new Date(year, month, 1).getDay();

            let date = 1;
            for (let i = 0; i < 6; i++) {
                let row = '<tr>';
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDay) {
                        row += '<td></td>';
                    } else if (date > daysInMonth) {
                        row += '<td></td>';
                    } else {
                        const currentDate = new Date(year, month, date);
                        const dayClass = currentDate.getDay() === 6 ? 'saturday' : currentDate.getDay() === 0 ? 'sunday' : '';
                        const isPast = currentDate < today;
                        const dayString = `${String(date).padStart(2, '0')}-${String(month + 1).padStart(2, '0')}-${year}`;

                        row += `<td class="${dayClass} ${isPast ? 'disabled' : ''}">
                                    <span class="date-circle" onclick="redirectToTentativeList('${dayString}')">${date}</span>
                                </td>`;
                        date++;
                    }
                }
                row += '</tr>';
                calendarTable.innerHTML += row;
                if (date > daysInMonth) break;
            }
            monthDiv.appendChild(calendarTable);
            yearContainer.appendChild(monthDiv);
        }
    }

    function redirectToTentativeList(date) {
        const url = `tentative_list.php?date=${date}`;
        window.location.href = url;
    }

    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            generateYearCalendar(parseInt(tab.getAttribute('data-year')));
        });
    });

    generateYearCalendar(today.getFullYear());
</script>

</body>
</html>

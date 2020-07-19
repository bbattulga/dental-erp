<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MonFamily</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('js/apps/timetable/public/build/bundle.css')}}">

    <style>
        * {
  box-sizing: border-box;
  font-family: 'Roboto', sans-serif;
  list-style: none;
  margin: 0;
  outline: none;
  padding: 0;
}

a {
  text-decoration: none;
}

body, html {
  height: 100%;
}

body {
    background: #dfebed;
    font-family: 'Roboto', sans-serif;
}

.container {
    align-items: center;
    display: flex;
    height: 100%;
    justify-content: center;
    margin: 0 auto;
    max-width: 600px;
    width: 100%;
}

.calendar {
    background: #2b4450;
    border-radius: 4px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .3);
    height: 501px;
  perspective: 1000;
    transition: .9s;
    transform-style: preserve-3d;
    width: 100%;
}

/* Front - Calendar */
.front {
    transform: rotateY(0deg);
}

.current-date {
    border-bottom: 1px solid rgba(73, 114, 133, .6);
    display: flex;
    justify-content: space-between;
    padding: 30px 40px;
}

.current-date h1 {
    color: #dfebed;
    font-size: 1.4em;
    font-weight: 300;
}

.week-days {
    color: #dfebed;
    display: flex;
    justify-content: space-between;
    font-weight: 600;
    padding: 30px 40px;
}

.days {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.weeks {
    color: #fff;
    display: flex;
    flex-direction: column;
    padding: 0 40px;
}

.weeks div {
    display: flex;
    font-size: 1.2em;
    font-weight: 300;
    justify-content: space-between;
    margin-bottom: 20px;
    width: 100%;
}

.last-month {
    opacity: .3;
}

.weeks span {
    padding: 10px;
}

.weeks span.active {
    background: #f78536;
    border-radius: 50%;
}

.weeks span:not(.last-month):hover {
    cursor: pointer;
    font-weight: 600;
}

.event {
    position: relative;
}

.event:after {
    content: '•';
    color: #f78536;
    font-size: 1.4em;
    position: absolute;
    right: -4px;
    top: -4px;
}

/* Back - Event form */

.back {
    height: 100%;
    transform: rotateY(180deg);
}

.back input {
    background: none;
    border: none;
    border-bottom: 1px solid rgba(73, 114, 133, .6);
    color: #dfebed;
    font-size: 1.4em;
    font-weight: 300;
    padding: 30px 40px;
    width: 100%;
}

.info {
    color: #dfebed;
    display: flex;
    flex-direction: column;
    font-weight: 600;
    font-size: 1.2em;
    padding: 30px 40px;
}

.info div:not(.observations) {
    margin-bottom: 40px;
}

.info span {
    font-weight: 300;
}

.info .date {
    display: flex;
    justify-content: space-between;
}

.info .date p {
    width: 50%;
}

.info .address p {
    width: 100%;
}

.actions {
    bottom: 0;
    border-top: 1px solid rgba(73, 114, 133, .6);
    display: flex;
    justify-content: space-between;
    position: absolute;
    width: 100%;
}

.actions button {
    background: none;
    border: 0;
    color: #fff;
    font-weight: 600;
    letter-spacing: 3px;
    margin: 0;
    padding: 30px 0;
    text-transform: uppercase;
    width: 50%;
}

.actions button:first-of-type {
    border-right: 1px solid rgba(73, 114, 133, .6);
}

.actions button:hover {
    background: #497285;
    cursor: pointer;
}

.actions button:active {
    background: #5889a0;
    outline: none;
}

/* Flip animation */

.flip {
    transform: rotateY(180deg);
}

.front, .back {
    backface-visibility: hidden;
}

    </style>
</head>


<body>

    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment.min.js" type="text/javascript"></script>

    <!--
    <div id="timetable"></div>

    <script src="{{asset('js/apps/timetable/public/build/bundle.js')}}" type="text/javascript"></script>
-->


    <div class="container">
      <div class="calendar">
        <div class="front">
          <div class="current-date">
            <h1>Friday 15th</h1>
            <h1>January 2016</h1>   
          </div>

          <div class="current-month">
            <ul class="week-days">
              <li>MON</li>
              <li>TUE</li>
              <li>WED</li>
              <li>THU</li>
              <li>FRI</li>
              <li>SAT</li>
              <li>SUN</li>
            </ul>

            <div class="weeks">
              <div class="first">
                <span class="last-month">28</span>
                <span class="last-month">29</span>
                <span class="last-month">30</span>
                <span class="last-month">31</span>
                <span>01</span>
                <span>02</span>
                <span>03</span>
              </div>

              <div class="second">
                <span>04</span>
                <span>05</span>
                <span class="event">06</span>
                <span>07</span>
                <span>08</span>
                <span>09</span>
                <span>10</span>
              </div>

              <div class="third">
                <span>11</span>
                <span>12</span>
                <span>13</span>
                <span>14</span>
                <span class="active">15</span>
                <span>16</span>
                <span>17</span>
              </div>

              <div class="fourth">
                <span>18</span>
                <span>19</span>
                <span>20</span>
                <span>21</span>
                <span>22</span>
                <span>23</span>
                <span>24</span>
              </div>

              <div class="fifth">
                <span>25</span>
                <span>26</span>
                <span>27</span>
                <span>28</span>
                <span>29</span>
                <span>30</span>
                <span>31</span>
              </div>
            </div>
          </div>
        </div>

        <div class="back">
          <input placeholder="What's the event?">
          <div class="info">
            <div class="date">
              <p class="info-date">
              Date: <span>Jan 15th, 2016</span>
              </p>
              <p class="info-time">
                Time: <span>6:35 PM</span>
              </p>
            </div>
            <div class="address">
              <p>
                Address: <span>129 W 81st St, New York, NY</span>
              </p>
            </div>
            <div class="observations">
              <p>
                Observations: <span>Be there 15 minutes earlier</span>
              </p>
            </div>
          </div>

          <div class="actions">
            <button class="save">
              Save <i class="ion-checkmark"></i>
            </button>
            <button class="dismiss">
              Dismiss <i class="ion-android-close"></i>
            </button>
          </div>
        </div>

      </div>
    </div>

</body>

</html>
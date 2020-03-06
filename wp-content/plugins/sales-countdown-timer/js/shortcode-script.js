'use strict';
let count = 0;
let x;
x = setInterval(function () {
    count++;
}, 1000);

jQuery(document).ready(function ($) {
//sales countdown timer
    clearInterval(x);
    let distance, date, hours, minutes, seconds, i;
    let dates_deg, hours_deg, minutes_deg, seconds_deg;
    // Update the count down every 1 second
    let wooCountdown = $('.woo-sctr-shortcode-wrap-wrap');
    distance = $('.woo-sctr-shortcode-data-end_time').map(function () {
        return parseInt($(this).val()) - count;
    });
    x = setInterval(function () {
        count++;
        for (i = 0; i < wooCountdown.length; i++) {
            let container = $('.woo-sctr-shortcode-wrap-wrap').eq(i),
                date_container = container.find('.woo-sctr-shortcode-countdown-date'),
                hour_container = container.find('.woo-sctr-shortcode-countdown-hour'),
                minute_container = container.find('.woo-sctr-shortcode-countdown-minute'),
                second_container = container.find('.woo-sctr-shortcode-countdown-second');
            date = Math.floor(distance[i] / 86400);
            hours = Math.floor((distance[i] % (86400)) / (3600));
            minutes = Math.floor((distance[i] % (3600)) / (60));
            seconds = Math.floor((distance[i] % (60)));
            seconds_deg = seconds * 6;
            if (seconds_deg < 180) {
                second_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                second_container.find('.woo-sctr-first50-bar').hide();
            } else {
                second_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');

                second_container.find('.woo-sctr-first50-bar').show();
            }
            second_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + seconds_deg + 'deg)'});
            /**/
            second_container.find('.woo-sctr-shortcode-countdown-second-value-container-2').addClass('transition');
            setTimeout(function () {
                second_container.find('.woo-sctr-shortcode-countdown-second-value-container-2').removeClass('transition');
                second_container.find('.woo-sctr-shortcode-countdown-second-value-1').html((seconds > 0) ? ("0" + (seconds - 1)).slice(-2) : '59');
                second_container.find('.woo-sctr-shortcode-countdown-second-value-2').html(("0" + seconds).slice(-2));
            }, 500);
            if (seconds == 0 && (minutes > 0 || hours > 0 || date > 0)) {
                minutes_deg = (minutes > 0 ? (minutes - 1) : 59) * 6;
                if (minutes_deg < 180) {
                    minute_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                    minute_container.find('.woo-sctr-first50-bar').hide();
                } else {
                    minute_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                    minute_container.find('.woo-sctr-first50-bar').show();
                }
                setTimeout(function () {
                    minute_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + minutes_deg + 'deg)'});
                    minute_container.find('.woo-sctr-shortcode-countdown-minute-value-container-2').addClass('transition');
                    setTimeout(function () {
                        minute_container.find('.woo-sctr-shortcode-countdown-minute-value-container-2').removeClass('transition');
                        minute_container.find('.woo-sctr-shortcode-countdown-minute-value-1').html((minutes > 0) ? ("0" + (minutes - 1)).slice(-2) : '59');
                        minute_container.find('.woo-sctr-shortcode-countdown-minute-value-2').html(("0" + minutes).slice(-2));
                    }, 500);
                }, 1000);

                if (minutes == 0 && (hours > 0 || date > 0)) {
                    hours_deg = (hours > 0 ? (hours - 1) : 23) * 15;
                    if (hours_deg < 180) {
                        hour_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                        hour_container.find('.woo-sctr-first50-bar').hide();
                    } else {
                        hour_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                        hour_container.find('.woo-sctr-first50-bar').show();
                    }
                    setTimeout(function () {
                        hour_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + hours_deg + 'deg)'});
                        hour_container.find('.woo-sctr-shortcode-countdown-hour-value-container-2').addClass('transition');
                        setTimeout(function () {
                            hour_container.find('.woo-sctr-shortcode-countdown-hour-value-container-2').removeClass('transition');
                            hour_container.find('.woo-sctr-shortcode-countdown-hour-value-1').html((hours > 0) ? ("0" + (hours - 1)).slice(-2) : '23');
                            hour_container.find('.woo-sctr-shortcode-countdown-hour-value-2').html(("0" + hours).slice(-2));

                        }, 500);
                    }, 1000);

                    if (hours == 0 && date > 0) {
                        dates_deg = date > 0 ? (date - 1) : 0;
                        if (dates_deg < 180) {
                            date_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                            date_container.find('.woo-sctr-first50-bar').hide();
                        } else {
                            date_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                            date_container.find('.woo-sctr-first50-bar').show();
                        }
                        setTimeout(function () {
                            date_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + dates_deg + 'deg)'});
                            date_container.find('.woo-sctr-shortcode-countdown-date-value-container-2').addClass('transition');
                            setTimeout(function () {
                                date_container.find('.woo-sctr-shortcode-countdown-date-value-container-2').removeClass('transition');
                                date_container.find('.woo-sctr-shortcode-countdown-date-value-1').html((date > 0) ? ("0" + (date - 1)).slice(-2) : '00');
                                date_container.find('.woo-sctr-shortcode-countdown-date-value-2').html(("0" + date).slice(-2));

                            }, 500);
                        }, 1000);

                    }
                }
            }
            if (date < 100) {
                date = ("0" + date).slice(-2);
                if (date == 0) {
                    container.find('.woo-sctr-shortcode-countdown-date').hide();
                    container.find('.woo-sctr-shortcode-wrap-wrap').find('.woo-sctr-shortcode-countdown-time-separator').eq(0).hide();
                }
            }
            date_container.find('.woo-sctr-shortcode-countdown-date-value').html(date);
            hour_container.find('.woo-sctr-shortcode-countdown-hour-value').html(("0" + hours).slice(-2));
            minute_container.find('.woo-sctr-shortcode-countdown-minute-value').html(("0" + minutes).slice(-2));
            second_container.find('.woo-sctr-shortcode-countdown-second-value').html(("0" + seconds).slice(-2));
            distance[i]--;
            if (distance[i] < 0) {
                clearInterval(x);
                window.location.href = window.location.href;
            }
        }
    }, 1000);
    $(".single_variation_wrap").on("show_variation", function (event, variation) {
        // Fired when the user selects all the required dropdowns / attributes
        // and a final variation is selected / shown
        clearInterval(x);
        // var distance, date, hours, minutes, seconds, i;
        // Update the count down every 1 second
        wooCountdown = $('.woo-sctr-shortcode-wrap-wrap');
        distance = $('.woo-sctr-shortcode-data-end_time').map(function () {
            return parseInt($(this).val()) - count - 1;
        });
        for (i = 0; i < wooCountdown.length; i++) {
            if (distance[i] < 0) {
                clearInterval(x);
                window.location.href = window.location.href;
            }
            let container = $('.woo-sctr-shortcode-wrap-wrap').eq(i),
                date_container = container.find('.woo-sctr-shortcode-countdown-date'),
                hour_container = container.find('.woo-sctr-shortcode-countdown-hour'),
                minute_container = container.find('.woo-sctr-shortcode-countdown-minute'),
                second_container = container.find('.woo-sctr-shortcode-countdown-second');
            date = Math.floor(distance[i] / 86400);
            hours = Math.floor((distance[i] % (86400)) / (3600));
            minutes = Math.floor((distance[i] % (3600)) / (60));
            seconds = Math.floor((distance[i] % (60)));
            seconds_deg = seconds * 6;
            if (seconds_deg < 180) {
                second_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                second_container.find('.woo-sctr-first50-bar').hide();
            } else {
                second_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                second_container.find('.woo-sctr-first50-bar').show();
            }
            second_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + seconds_deg + 'deg)'});
            minutes_deg = minutes * 6;
            if (minutes_deg < 180) {
                minute_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                minute_container.find('.woo-sctr-first50-bar').hide();
            } else {
                minute_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                minute_container.find('.woo-sctr-first50-bar').show();
            }
            minute_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + minutes_deg + 'deg)'});
            hours_deg = hours * 15;
            if (hours_deg < 180) {
                hour_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                hour_container.find('.woo-sctr-first50-bar').hide();
            } else {
                hour_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                hour_container.find('.woo-sctr-first50-bar').show();
            }
            hour_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + hours_deg + 'deg)'});
            dates_deg = date;
            if (dates_deg < 180) {
                date_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                date_container.find('.woo-sctr-first50-bar').hide();
            } else {
                date_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                date_container.find('.woo-sctr-first50-bar').show();
            }
            date_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + dates_deg + 'deg)'});
            if (date < 100) {
                date = ("0" + date).slice(-2);
                if (date == 0) {
                    container.find('.woo-sctr-shortcode-countdown-date').hide();
                    container.find('.woo-sctr-shortcode-wrap-wrap').find('.woo-sctr-shortcode-countdown-time-separator').eq(0).hide();
                } else {
                    container.find('.woo-sctr-shortcode-countdown-date').eq(i).show();
                    container.find('.woo-sctr-shortcode-wrap-wrap').find('.woo-sctr-shortcode-countdown-time-separator').eq(0).show();
                }
            }
            second_container.find('.woo-sctr-shortcode-countdown-second-value-1').html((seconds > 0) ? ("0" + (seconds - 1)).slice(-2) : '59');
            second_container.find('.woo-sctr-shortcode-countdown-second-value-2').html(seconds);
            minute_container.find('.woo-sctr-shortcode-countdown-minute-value-1').html((minutes > 0) ? ("0" + (minutes - 1)).slice(-2) : '59');
            minute_container.find('.woo-sctr-shortcode-countdown-minute-value-2').html(minutes);
            hour_container.find('.woo-sctr-shortcode-countdown-hour-value-1').html((hours > 0) ? ("0" + (hours - 1)).slice(-2) : '23');
            hour_container.find('.woo-sctr-shortcode-countdown-hour-value-2').html(hours);
            date_container.find('.woo-sctr-shortcode-countdown-date-value-1').html((date > 0) ? ("0" + (date - 1)).slice(-2) : '00');
            date_container.find('.woo-sctr-shortcode-countdown-date-value-2').html(date);
            distance[i]--;

        }

        x = setInterval(function () {
            count++;
            for (i = 0; i < wooCountdown.length; i++) {
                let container = $('.woo-sctr-shortcode-wrap-wrap').eq(i),
                    date_container = container.find('.woo-sctr-shortcode-countdown-date'),
                    hour_container = container.find('.woo-sctr-shortcode-countdown-hour'),
                    minute_container = container.find('.woo-sctr-shortcode-countdown-minute'),
                    second_container = container.find('.woo-sctr-shortcode-countdown-second');
                date = Math.floor(distance[i] / 86400);
                hours = Math.floor((distance[i] % (86400)) / (3600));
                minutes = Math.floor((distance[i] % (3600)) / (60));
                seconds = Math.floor((distance[i] % (60)));


                seconds_deg = seconds * 6;
                if (seconds_deg < 180) {
                    second_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                    second_container.find('.woo-sctr-first50-bar').hide();
                } else {
                    second_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                    second_container.find('.woo-sctr-first50-bar').show();
                }
                second_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + seconds_deg + 'deg)'});

                /**/
                second_container.find('.woo-sctr-shortcode-countdown-second-value-container-2').addClass('transition');
                setTimeout(function () {
                    second_container.find('.woo-sctr-shortcode-countdown-second-value-container-2').removeClass('transition');
                    second_container.find('.woo-sctr-shortcode-countdown-second-value-1').html((seconds > 0) ? ("0" + (seconds - 1)).slice(-2) : '59');
                    second_container.find('.woo-sctr-shortcode-countdown-second-value-2').html(("0" + seconds).slice(-2));

                }, 500);
                if (seconds == 0 && (minutes > 0 || hours > 0 || date > 0)) {
                    minutes_deg = (minutes > 0 ? (minutes - 1) : 59) * 6;
                    if (minutes_deg < 180) {
                        minute_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                        minute_container.find('.woo-sctr-first50-bar').hide();
                    } else {
                        minute_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                        minute_container.find('.woo-sctr-first50-bar').show();
                    }
                    setTimeout(function () {
                        minute_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + minutes_deg + 'deg)'});
                        minute_container.find('.woo-sctr-shortcode-countdown-minute-value-container-2').addClass('transition');
                        setTimeout(function () {
                            minute_container.find('.woo-sctr-shortcode-countdown-minute-value-container-2').removeClass('transition');
                            minute_container.find('.woo-sctr-shortcode-countdown-minute-value-1').html((minutes > 0) ? ("0" + (minutes - 1)).slice(-2) : '59');
                            minute_container.find('.woo-sctr-shortcode-countdown-minute-value-2').html(("0" + minutes).slice(-2));
                        }, 500);
                    }, 1000);

                    if (minutes == 0 && (hours > 0 || date > 0)) {
                        hours_deg = (hours > 0 ? (hours - 1) : 23) * 15;
                        if (hours_deg < 180) {
                            hour_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                            hour_container.find('.woo-sctr-first50-bar').hide();
                        } else {
                            hour_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                            hour_container.find('.woo-sctr-first50-bar').show();
                        }
                        setTimeout(function () {
                            hour_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + hours_deg + 'deg)'});
                            hour_container.find('.woo-sctr-shortcode-countdown-hour-value-container-2').addClass('transition');
                            setTimeout(function () {
                                hour_container.find('.woo-sctr-shortcode-countdown-hour-value-container-2').removeClass('transition');
                                hour_container.find('.woo-sctr-shortcode-countdown-hour-value-1').html((hours > 0) ? ("0" + (hours - 1)).slice(-2) : '23');
                                hour_container.find('.woo-sctr-shortcode-countdown-hour-value-2').html(("0" + hours).slice(-2));

                            }, 500);
                        }, 1000);

                        if (hours == 0 && date > 0) {
                            dates_deg = date > 0 ? (date - 1) : 0;
                            if (dates_deg < 180) {
                                date_container.find('.woo-sctr-progress-circle').removeClass('woo-sctr-over50');
                                date_container.find('.woo-sctr-first50-bar').hide();
                            } else {
                                date_container.find('.woo-sctr-progress-circle').addClass('woo-sctr-over50');
                                date_container.find('.woo-sctr-first50-bar').show();
                            }
                            setTimeout(function () {
                                date_container.find('.woo-sctr-value-bar').css({'transform': 'rotate(' + dates_deg + 'deg)'});
                                date_container.find('.woo-sctr-shortcode-countdown-date-value-container-2').addClass('transition');
                                setTimeout(function () {
                                    date_container.find('.woo-sctr-shortcode-countdown-date-value-container-2').removeClass('transition');
                                    date_container.find('.woo-sctr-shortcode-countdown-date-value-1').html((date > 0) ? ("0" + (date - 1)).slice(-2) : '00');
                                    date_container.find('.woo-sctr-shortcode-countdown-date-value-2').html(("0" + date).slice(-2));

                                }, 500);
                            }, 1000);

                        }
                    }
                }
                if (date < 100) {
                    date = ("0" + date).slice(-2);
                    if (date == 0) {
                        container.find('.woo-sctr-shortcode-countdown-date').hide();
                        container.find('.woo-sctr-shortcode-wrap-wrap').find('.woo-sctr-shortcode-countdown-time-separator').eq(0).hide();
                    } else {
                        container.find('.woo-sctr-shortcode-countdown-date').show();
                        container.find('.woo-sctr-shortcode-wrap-wrap').find('.woo-sctr-shortcode-countdown-time-separator').eq(0).show();
                    }
                }
                date_container.find('.woo-sctr-shortcode-countdown-date-value').html(date);
                hour_container.find('.woo-sctr-shortcode-countdown-hour-value').html(("0" + hours).slice(-2));
                minute_container.find('.woo-sctr-shortcode-countdown-minute-value').html(("0" + minutes).slice(-2));
                second_container.find('.woo-sctr-shortcode-countdown-second-value').html(("0" + seconds).slice(-2));

                distance[i]--;
                if (distance[i] < 0) {
                    clearInterval(x);
                    window.location.href = window.location.href;
                }
            }
        }, 1000);
    });

});

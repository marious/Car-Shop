import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';


// let timezone = require('dayjs/plugin/timezone');
dayjs.extend(utc);
// dayjs.extend(timezone);

const common = () => {

    const formatDate = (date, format = null) => {
        if (date == undefined) {
            return dayjs()
                .format(
                    format
                )
        } else {
            return dayjs(date)
                .format(
                    format
                )
        }
    }

    const dayjsObject = (date) => {
        if (date == undefined) {
            return dayjs()
                .tz('Africa/Cairo');
        } else {
            return dayjs(date)
                .tz('Africa/Cairo');
        }
    }

    return {
        dayjsObject,
        dayjs,
        formatDate
    }
};

export default common;

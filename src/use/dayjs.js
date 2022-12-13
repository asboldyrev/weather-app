import dayjs from 'dayjs'
import ruLocale from 'dayjs/locale/ru'
import utc from 'dayjs/plugin/utc'
import timezone from 'dayjs/plugin/timezone'

dayjs.locale(ruLocale);
dayjs.extend(utc);
dayjs.extend(timezone);

export default () => {
	return dayjs();
}

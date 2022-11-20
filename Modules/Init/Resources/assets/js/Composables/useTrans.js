import {useLang} from "./useLang";

export function useTrans() {
    function trans(key) {
        const { lang } = useLang();
        return lang()[key] ? lang()[key] : key;
    }
    return { trans };
}

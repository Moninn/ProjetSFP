function formatDate(d) {
    const pad = n => String(n).padStart(2, '0');
    const date = d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate());
    const time = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
    return `${date} ${time} ${tz}`;
}

function setGeneratedAt() {
    const elem = document.querySelector('.generated-at');
    if (elem) elem.textContent = formatDate(new Date());
}

setGeneratedAt();
setInterval(setGeneratedAt, 1000);

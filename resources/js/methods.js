

const methods = {
    downloadCSV(chartName, headers, rows) {
        const csvContent = []
        .concat([headers])
        .concat(rows)
        .join('\n');
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `${chartName}_${Date.now()}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
    },
    showMessage(message) {
        this.message = message;
        setTimeout(() => {
            this.message = null;
        }, 5000);
    },
    getToken() {
        return localStorage.getItem('auth_token');
    },
    setToken(token) {
        localStorage.setItem('auth_token', token);
    },
    clearToken() {
        localStorage.removeItem('auth_token');
    },
}

export default methods;
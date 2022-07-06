export function weather(data) {
    return request('api/weather', data);
}

export function autocomplete(query) {
    return request('api/autocomplete', { query: query });
}


function request(uri, body = {}) {
    const data = {
        method: 'post',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json;charset=utf-8',
        },
        body: ''
    };

    if (body) {
        data.body = JSON.stringify(body);
    }

    return fetch(uri, data).then(response => response.json());
}

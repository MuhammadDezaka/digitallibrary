/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */
/**
 * Handle Error Request
 */

//define axios


const handleErrorRequest = (errorResponse) => {
    response = errorResponse.response;
    if (response.status === 422) {
        errors = response.data.errors;
        $.each(errors, (_, error) => {
            Swal.fire('Warning', error[0], 'warning');
            return false;
        });
    } else {
        data = response.data;
        Swal.fire('Error', data.message, 'error');
        return false;
    }
};

window.showLoadingSwal = () => {
    Swal.fire({
        title: 'Please Wait',
        imageUrl: `${window.baseURL}/assets-admin/img/loading_.gif`,
        allowOutsideClick: false,
        showCancelButton: false,
        showConfirmButton: false
    })
}

const actionPagination = (element, event, table) => {
    event.preventDefault();
    table.baseURL = element.getAttribute('href');
    table.loadDataTables();
};

const renderPagination = (links, $container) => {
    // console.log('ada')
    linksHtml = `<ul class="pagination m-3">`;
    links.forEach(item => {
        linksHtml += `<li class="page-item ${item.active ? 'active' : ''} ${item.url == null ? 'disabled' : ''}">
            <a class="page-link" href="${item.url}" onclick="actionPagination(this, event, table)">${item.label}</a>
        </li>`;
    });
    linksHtml += '</ul>';

    $container.html(linksHtml);
};

const renderChart = (data, categories, label, selector, color) => {
    options = {
        series: [{
            name: label,
            data: data
        },],
        chart: {
            height: 350,
            type: 'area',
            dropShadow: {
                enabled: true,
                color: '#000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.2
            },
            toolbar: {
                show: true
            }
        },
        colors: [color, '#F98404'],
        dataLabels: {
            enabled: true,
        },
        stroke: {
            curve: 'smooth'
        },
        title: {
            text: '',
            align: 'left'
        },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: categories,
            title: {
                text: 'Tanggal'
            }
        },
        yaxis: {
            title: {
                text: label
            },
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        },
        tooltip: {
            custom: function ({
                series, seriesIndex, dataPointIndex, w
            }) {
                return '<div class="arrow_box">' +
                    '<span class="text-bold">' + label + ' : ' + series[seriesIndex][dataPointIndex] + '</span> <br>' +
                    '</div>'
            }
        }
    };

    chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}

const showDeleteConfirmation = () => {
    return new Promise((resolve, reject) => {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, saya yakin!'
        }).then((result) => {
            return resolve({
                status: result.isConfirmed
            });
        })
    });
};

const showConfirmation = (msg) => {
    return new Promise((resolve, reject) => {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: msg,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, saya yakin!'
        }).then((result) => {
            return resolve({
                status: result.isConfirmed
            });
        })
    });
};

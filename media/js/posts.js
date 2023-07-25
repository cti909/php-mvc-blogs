// filter
let select_categories = document.querySelector('#categories');
let option_category = document.getElementById("categories").value;

let sort_name = document.querySelector('input[name="sort"]:checked').value;
let sort = document.querySelectorAll('input[name="sort"]');

let searchText = document.getElementById("search_token").value

let page_count = parseInt(document.getElementById("page_count").value);
let page_current = parseInt(document.getElementById("page_current").value);

// add event for option
select_categories.addEventListener('change', (event) => {
    option_category = event.target.value;
    page_current = 1;
    window.location.href = "?ctl=posts&act=index&category="+option_category+"&sort="+sort_name+"&search_token="+searchText+"&page="+page_current
});

sort.forEach(option => {
    option.addEventListener('change', (event) => {
        sort_name = event.target.value;
        page_current = 1;
        window.location.href = "?ctl=posts&act=index&category="+option_category+"&sort="+sort_name+"&search_token="+searchText+"&page="+page_current
    });
});

let form = document.getElementById('search_content');
form.addEventListener('submit', function(event) {
    event.preventDefault();
    let product_search = document.getElementById("search_token");
    let searchText = product_search.value.toLowerCase();
    page_current = 1;
    window.location.href = "?ctl=posts&act=index&category="+option_category+"&sort="+sort_name+"&search_token="+searchText+"&page="+page_current
});


// -----pagination-----
let paginationUl = document.getElementById("pagination");
// Tạo nút Previous
let prevPageLi = document.createElement("li");
prevPageLi.classList.add("page-item");
prevPageLi.setAttribute("id", "pagination_prev");
let prevPageLink = document.createElement("a");
prevPageLink.classList.add("page-link");
let prevPageIcon = document.createElement("i");
prevPageIcon.classList.add("fa-solid", "fa-angle-left");
prevPageLink.appendChild(prevPageIcon);
prevPageLi.appendChild(prevPageLink);
paginationUl.appendChild(prevPageLi);
if (page_current == 1) {
    prevPageLi.classList.add("disabled");
}
prevPageLink.addEventListener("click", function(event) {
    event.preventDefault();
    window.location.href = "?ctl=posts&act=index&category="+option_category+"&sort="+sort_name+"&search_token="+searchText+"&page="+(page_current-1)
});

// Tạo các nút trang
for (let i = 1; i <= page_count; i++) {
    let pageLi = document.createElement("li");
    pageLi.classList.add("page-item");
    if (i == page_current) {
        pageLi.classList.add("active");
    }
    let pageLink = document.createElement("a");
    pageLink.classList.add("page-link");
    // pageLink.setAttribute("href", "?page="+""+i);
    pageLink.addEventListener("click", function(event) {
        event.preventDefault();
        window.location.href = "?ctl=posts&act=index&category="+option_category+"&sort="+sort_name+"&search_token="+searchText+"&page="+i
    });
    pageLink.innerText = i;
    pageLi.appendChild(pageLink);
    paginationUl.appendChild(pageLi);
}

// Tạo nút Next
let nextPageLi = document.createElement("li");
nextPageLi.classList.add("page-item");
nextPageLi.setAttribute("id", "pagination_next");
let nextPageLink = document.createElement("a");
nextPageLink.classList.add("page-link");
let nextPageIcon = document.createElement("i");
nextPageIcon.classList.add("fa-solid", "fa-angle-right");
nextPageLink.appendChild(nextPageIcon);
nextPageLi.appendChild(nextPageLink);
paginationUl.appendChild(nextPageLi);
if (page_current == page_count || page_count == 0) {
    nextPageLi.classList.add("disabled");
}
nextPageLink.addEventListener("click", function(event) {
    event.preventDefault();
    window.location.href = "?ctl=posts&act=index&category="+option_category+"&sort="+sort_name+"&search_token="+searchText+"&page="+(page_current+1)
});
// -----end pagination-----
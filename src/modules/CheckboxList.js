let categories = [5,6];
const url ='http://university.test/wp-json/wp/v2/event';
let kq = [];
categories.forEach((item) => {
   fetch(`${url}?event-type=${item}`).then(response => response.json()).then((data) => console.log(data));
})
console.log(kq);





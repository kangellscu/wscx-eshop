$(function() {
    reder()
})

function reder() {
    var option = {
        url: "js/data.json",
        navkey: {
            "keyarr": ["正装", "s"],
            "allkey": "女装"
        },
        callback: {
            selectorsure: selectorsure,
            abiqiancli: abiqiancli,
        },

    }

    function selectorsure(arr) {
        //arr为确定按钮之后输出的搜索条件
        console.log(arr);
    }

    function abiqiancli(navarr) {
        //每一条数据之后的搜索条件
        console.log("nav关键字" + navarr)
    }

    $("#searchcon").SEarch(option);
}
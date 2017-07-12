$.ajax({
    type: 'POST',
    url: '". Url::to(['jogada/save']) ."',
    data: {
        pontuacao: pontuacao
    },
    success: function(data) {
        console.log(data);
    }
});

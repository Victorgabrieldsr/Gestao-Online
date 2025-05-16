<article class="blocos-informativos">
    <div>
        <img class="img-blocos" src="../icon/totalinvestido.png">
        <label>Total Investido em Criptomoeda</label>
        <label><span>R$ </span> <?= $_SESSION['totalInvestidoCripto']; ?></label>
    </div>
    <div>
        <img class="img-blocos" src="../icon/ethereum.png">
        <label>Total em Criptomoeda</label>
        <label><span>R$ <?= $_SESSION['totalCripto'] ?></span> </label>
        <!-- <label class="porcentagemTotal"><img src="../icon/trianguloVerde.png">R$ (%)</label> -->
    </div>
    <div>
        <img class="img-blocos totalretirado" src="../icon/line-graph.png">
        <label>Lucro/Prejuízo</label>
        <label><span>R$ <?= $_SESSION['totalLucroEPerda']; ?> </span> </label>
    </div>
    <div>
        <img class="img-blocos totalretirado" src="../icon/totalretirado.png">
        <label>Total Retirado</label>
        <label><span>R$ </span> <?= $_SESSION['totalRetiradoCripto']; ?></label>
    </div>
</article>
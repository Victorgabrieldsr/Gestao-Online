<article class="blocos-informativos">
    <div>
        <img class="img-blocos" src="../icon/totalinvestido.png">
        <label>Total em Investimento</label>
        <label><span>R$ </span> <?= $_SESSION['totalInvestido']; ?></label>
        <label class="porcentagemTotal"><img src="../icon/trianguloVerde.png">R$ <?= $_SESSION['totalRendimento']; ?> (<?= $_SESSION['porcentagemTotal']; ?>%)</label>
    </div>
    <div>
        <img class="img-blocos" src="../icon/redimento.png">
        <label>Total de Proventos</label>
        <label><span>R$ </span> <?= $_SESSION['totalRendimento']; ?></label>
    </div>
    <div>
        <img class="img-blocos" src="../icon/proventos.png">
        <label>Proventos Recebido no Mês</label>
        <label><span>R$ </span> <?= $_SESSION['totalProventoMes']; ?></label>
    </div>
    <div>
        <img class="img-blocos totalretirado" src="../icon/totalretirado.png">
        <label>Total Retirado</label>
        <label><span>R$ </span> <?= $_SESSION['totalRetirado']; ?></label>
    </div>
</article>

<article class="infoNotas">
        <div class="table-container">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Nome Cripto</th>
                            <th>Data Compra</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Valor Total</th>
                            <th>Quantidade Atual</th>
                            <th>Valor Atual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        $stmt = $conn->prepare("SELECT id, nomeCripto, DATE_FORMAT(dataCompra, '%d/%m/%Y') as dataCompra, descricao, quantidade, valorTotal, quantidadeAtual, valorAtual, tipo, bola FROM investimento.criptos WHERE idUser = ? ORDER BY datacompra DESC, id DESC;");
                        $stmt->bind_param('i', $_SESSION['idUser']);
                        $stmt->execute();
                        $resultado = $stmt->get_result();
                        if($resultado->num_rows > 0){
                            while($row = $resultado->fetch_assoc()){
                                $row['valorAtual'] = !empty($row['valorAtual']) ? number_format($row['valorAtual'], 2, ',', '.') : '';
                                echo"
                                    <tr>
                                        <td><div class='quadrado-bola'><span class=".$row['bola']."></span></div></td>
                                        <td class='td-img'>
                                        <button type='button' onclick='abrirEdicao(this)' 
                                            data-nomecripto='". $row['nomeCripto'] ."'
                                            data-datacompra='". $row['dataCompra'] ."'
                                            data-descricao='". $row['descricao'] ."'
                                            data-quantidade='". $row['quantidade']."'
                                            data-valortotal='". $row['valorTotal'] ."'
                                            data-tipo='". $row['tipo'] ."'
                                            data-id='". $row['id'] ."'>
                                            <div class='div-td-img'><img src='../icon/lapis.png'></div>
                                        </button>
                                    </td>
                                    
                                        <td class='td-img'>
                                            <form action='./config/excluirCripto.php' method='post'>
                                                <input type='hidden' name='id' value='".$row['id']."'>
                                                <input type='hidden' name='nomecripto' value='".$row['nomeCripto']."'>
                                                <input type='hidden' name='action' value='excluir'>
                                                <button type='submit'>
                                                    <div class='div-td-img'><img src='../icon/x.png'></div>
                                                </button>
                                            </form>
                                        </td>
                                        <td>".$row['nomeCripto']."</td>
                                        <td>".$row['dataCompra']."</td>
                                        <td>".$row['descricao']."</td>
                                        <td>". floatval(number_format((float)str_replace(',', '.', $row['quantidade']), 10, '.', '')) ."</td>
                                        <td>R$ ".number_format($row['valorTotal'], 2, ',', '.')."</td>
                                        <td>". $row['quantidadeAtual']."</td>
                                        <td>R$ ". $row['valorAtual']."</td>
                                    </tr>
                                ";
                            }
                        }
                    ?>
                
                    </tbody>
                </table>
            </div>
            <div class="pagination">
                <button>Ant</button>
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
                <button>5</button>
                <button>Seg</button>
            </div>
        </div>
    </article>
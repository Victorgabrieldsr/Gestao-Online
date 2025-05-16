<article class="infoNotas">
            <div class="table-container">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Nome Ativo</th>
                            <th>Categoria</th>
                            <th>Data Compra</th>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Preço Unit</th>
                            <th>Valor Total</th>
                            <th>% a.a</th>
                            <th>Valor Atual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php   
                            $stmt = $conn->prepare("SELECT id, nomeAtivo, categoria, DATE_FORMAT(dataCompra, '%d/%m/%Y') as dataCompra, descricao, quantidade, precoUnitario, valorTotal, porcentagemAno, valorAtual, tipo, bola FROM investimento.ativos WHERE idUser = ? ORDER BY datacompra DESC, id DESC;");
                            $stmt->bind_param('i', $_SESSION['idUser']);
                            $stmt->execute();
                            $resultado = $stmt->get_result();
                            if($resultado->num_rows > 0){
                                while($row = $resultado->fetch_assoc()){
                                    $row['valorAtual'] = !empty($row['valorAtual']) ? number_format($row['valorAtual'], 2, ',', '.') : '';
                                    echo"
                                        <tr>
                                            <td><div class='quadrado-bola'><span class=".$row['bola']."></span></div></td>
                                            <form action='?page=painel' method='post'>
                                                <td class='td-img'>
                                                    <input type='hidden' name='form_inserir' value='alterar'>
                                                    <input type='hidden' name='nomeativo' value='".$row['nomeAtivo']."'>
                                                    <input type='hidden' name='categoria' value='".$row['categoria']."'>
                                                    <input type='hidden' name='datacompra' value='".$row['dataCompra']."'>
                                                    <input type='hidden' name='descricao' value='".$row['descricao']."'>
                                                    <input type='hidden' name='quantidade' value='".$row['quantidade']."'>
                                                    <input type='hidden' name='precounitario' value='".$row['precoUnitario']."'>
                                                    <input type='hidden' name='valortotal' value='".$row['valorTotal']."'>
                                                    <input type='hidden' name='porcentagemano' value='".$row['porcentagemAno']."'>
                                                    <input type='hidden' name='tipo' value='".$row['tipo']."'>
                                                    <input type='hidden' name='id' value='".$row['id']."'>
                                                    <button type='submit'>
                                                        <div class='div-td-img'><img src='../icon/lapis.png'></div>
                                                    </button>
                                                </td>
                                            </form>
                                            <td class='td-img'>
                                                <form action='./config/excluirAtivo.php' method='post'>
                                                    <input type='hidden' name='id' value='".$row['id']."'>
                                                    <input type='hidden' name='action' value='excluir'>
                                                    <button type='submit'>
                                                        <div class='div-td-img'><img src='../icon/x.png'></div>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>".$row['nomeAtivo']."</td>
                                            <td>".$row['categoria']."</td>
                                            <td>".$row['dataCompra']."</td>
                                            <td>".$row['descricao']."</td>
                                            <td>".$row['quantidade']."</td>
                                            <td>R$ ".number_format($row['precoUnitario'], 2, ',', '.')."</td>
                                            <td>R$ ".number_format( $row['valorTotal'], 2, ',', '.')."</td>
                                            <td>".number_format($row['porcentagemAno'], 2, ',', '.')."%</td>
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
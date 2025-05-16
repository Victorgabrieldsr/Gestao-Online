<article class="divisor-cripto">
    <div class="container-cripto">
        <div class="grid-container">
            
        <?php
            $totalInvestido =  str_replace('.', '', $_SESSION['totalCripto']);
            $totalInvestido = floatval($totalInvestido);

            $stmt = $conn->prepare("SELECT nomeCripto, valorTotal FROM cotascriptos;");
            $stmt->execute();
            $resultado = $stmt->get_result();
            if($resultado->num_rows > 0){
                while($row = $resultado->fetch_assoc()){
                    $valorTotal =  str_replace('.', ',', $row['valorTotal']); 
                    $valorTotal = floatval($valorTotal);
                    $porcentagem = ($valorTotal * 100) / $totalInvestido;
                    $porcentagem = number_format($porcentagem, 0, '', '');

                    echo"
                        <article class='elements-cripto'>
                            <div>
                                <h1>".$row['nomeCripto']."</h1>
                                <div class='graficoChart' id='".$row['nomeCripto']."'></div>
                            </div>
                            <div>
                                <label>Total Aplicado</label>   
                                <label>R$ ".number_format($row['valorTotal'], 2, ',', '.')."</label>   
                            </div>
                            <div>
                                <label>Rendimento</label>   
                                <label>R$ 0,00</label>   
                            </div>
                            <div>
                                <label>Valor líquido</label>   
                                <label>R$ 0,00</label>   
                            </div>
                        </article>
                        <script>
                        var options = {
                            series: [".$porcentagem."],
                            chart: {
                                width: 100,
                                height: 100,
                                type: 'radialBar',
                            },
                            plotOptions: {
                                radialBar: {
                                hollow: {
                                    size: '40%', 
                                },
                                track: {
                                    strokeWidth: '100%', 
                                },
                                dataLabels: {
                                    name: {
                                    show: false, 
                                    },
                                    value: {
                                    fontSize: '14px', 
                                    offsetY: 2, 
                                    }
                                }
                                }
                            },
                            labels: [''],
                        };
    
                        var ".$row['nomeCripto']." = new ApexCharts(document.querySelector('#".$row['nomeCripto']."'), options);
                        ".$row['nomeCripto'].".render();
                        </script>
                    ";
                }
            }
        ?>

          
        </div>
    </div>
</article> 

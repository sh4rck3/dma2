<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import { TailwindPagination } from "laravel-vue-pagination";

export default {
    components: {
        AppLayout,
        TailwindPagination,
    },
    props: {
        dataPaymentsid: String,
    },
    data() {
        return {
            dataFuncionario: [],
            dataRelacionamento: [],
            valor: [],
            proxyRelacionamentos: [],
        };
    },
    methods: {
        somaC() {
            let total = 0;
            for (let i = 0; i < this.proxyRelacionamentos.length; i++) {
                if(this.proxyRelacionamentos[i].descricaoverba1.substring(0, 1) === 'C'){
                    total += parseFloat(this.proxyRelacionamentos[i].valor1.replace('.', '').replace(',', '.'));
                }
                
            }
            return total;

        },
        somaD() {
            let total = 0;
            for (let i = 0; i < this.proxyRelacionamentos.length; i++) {
                if(this.proxyRelacionamentos[i].descricaoverba1.substring(0, 1) === 'D'){
                    total += parseFloat(this.proxyRelacionamentos[i].valor1.replace('.', '').replace(',', '.'));
                }
                
            }
            return total;

        },
    },
    mounted() {
        axios
            .get(`/api/paymentuser/show/${this.dataPaymentsid}`)
            .then((response) => {
                console.log(response.data.dataPayment);
                this.dataEmpresa = response.data.dataPayment.empresa.substring(5);
                this.dataRecibo = response.data.dataPayment.recibo;
                this.dataMesreferencia = response.data.dataPayment.mesRef;
                this.dataEdereco = response.data.dataPayment.endereco;
                this.dataCnpj = response.data.dataPayment.cnpj;
                this.dataAdm = response.data.dataPayment.dataadm.substring(11);
                this.dataFuncionario = response.data.dataPayment.funcionario.split('-');
                this.codigoFuncionario = this.dataFuncionario[2].substring(5);
                this.dataRelacionamento = response.data.dataPayment.paymentxmladditionalsr;

                let valor = JSON.stringify(this.dataRelacionamento);
                this.proxyRelacionamentos = JSON.parse(valor);

                this.totalSomaC = this.somaC().toFixed(2);
                this.totalSomaD = this.somaD().toFixed(2);
                

                this.dataValorsalariobase = response.data.dataPayment.valorSalarioBase;
                this.dataValorBaseINNS = response.data.dataPayment.valorBaseINNS;
                this.dataValorBaseFGTS = response.data.dataPayment.valorBaseFGTS;
                this.dataValorBaseIRRF = response.data.dataPayment.valorBaseIRRF;
                this.dataValorFGTS = response.data.dataPayment.valorFGTS;
                this.dataAssinautra = response.data.dataPayment.dataAssinatura;
                console.log(this.totalSomaC);
                
            });
    },
};
</script>
<style type="text/css">
table td {
    border: 1px solid #000;
    padding: 5px;
}
</style>

<template>
    <AppLayout title="Profile">
        <template #header>
            <div class="flex justify-between">
                <div class="">
                    <h2
                        class="font-semibold text-xl text-gray-800 leading-tight"
                    >
                        Contracheque
                    </h2>
                </div>
                <div class="">
                    <a href="/paymentsresult">
                        <button class="ml-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded align-middle">
                            Voltar
                        </button>
                    </a>
                </div>
            </div>
        </template>

        <div class="py-12 font-serif text-xs">
            <div class="align-middle max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lg w-12/12 mx-auto"
                >
                    <!--list users-->
                    <div class="bg-slate-200">
                        <table class="w-full">
                            <thead class="thead-empresa">
                                <tr>
                                    <td class="w-2/3 border-b-0 border-r-0">
                                        <span 
                                        class="text-base font-extrabold"
                                            >
                                            {{ dataEmpresa }}
                                            </span
                                        >
                                    </td>
                                    <td class="w-1/3 border-b-0 border-l-0">
                                        <span class="text-base font-extrabold"
                                            >{{ dataRecibo }}</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-2/3 border-y-0 border-r-0">
                                        <span>Endereço:<br> {{ dataEdereco }}</span>
                                    </td>
                                    <td class="w-1/3 border-y-0 border-l-0">
                                        <span
                                            >Mês de Referência:
                                            {{ dataMesreferencia }}</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="w-2/3 border-t-0 border-r-0">
                                        <span> {{ dataCnpj }} </span>
                                    </td>
                                    <td
                                        class="w-1/3 border-t-0 border-l-0"
                                    ></td>
                                </tr>
                            </thead>
                        </table>
                        <table class="w-full">
                            <thead class="">
                                <tr>
                                    <td class="border-b-0 border-r-0">
                                        <span>Código:</span>
                                    </td>
                                    <td class="border-b-0 border-x-0">
                                        <span>Nome:</span>
                                    </td>
                                    <td class="border-b-0 border-x-0">
                                        <span>Admissão:</span>
                                    </td>
                                    <td class="border-b-0 border-x-0">
                                        <span>CBO:</span>
                                    </td>
                                    <td class="border-b-0 border-l-0">
                                        <span>Função:</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-t-0 border-r-0">
                                        <span>{{ dataFuncionario[0] }}</span>
                                    </td>
                                    <td class="border-t-0 border-x-0">
                                        <span>{{ dataFuncionario[1] }}</span>
                                    </td>
                                    <td class="border-t-0 border-x-0">
                                        <span>{{ dataAdm }}</span>
                                    </td>
                                    <td class="border-t-0 border-x-0">
                                        <span>{{ codigoFuncionario }}</span>
                                    </td>
                                    <td class="border-t-0 border-l-0">
                                        <span>{{ dataFuncionario[3] }}</span>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <table class="w-full">
                            <thead class="thead-descricao">
                                <tr>
                                    <td class="border-y-2">
                                        <span>Código</span>
                                    </td>
                                    <td class="td-descricao-II">
                                        <span>Descrição</span>
                                    </td>
                                    <td class="td-descricao-III">
                                        <span>Referência</span>
                                    </td>
                                    <td class="td-descricao-IV">
                                        <span>Vencimentos</span>
                                    </td>
                                    <td class="td-descricao-V">
                                        <span>Descontos</span>
                                    </td>
                                </tr>
                                <tr 
                                v-for="proxyRelacionamento in proxyRelacionamentos" :key="proxyRelacionamento.id"
                                class="leading-4">
                                    <td class="border-none" >
                                        <span   
                                        >{{ proxyRelacionamento.descricaoverba1.substring(0, 5) }}<br></span>
                                    </td>
                                    <td class="border-none">
                                        <span>{{ proxyRelacionamento.descricaoverba1.substring(6) }} </span><br />
                                    </td>
                                    <td class="border-none">
                                        <span>{{ proxyRelacionamento.percentual1 }} </span><br />
                                    </td>
                                    <td class="border-none">
                                        <span 
                                            v-if="proxyRelacionamento.descricaoverba1.substring(0, 1) == 'C'"
                                            valorC="{{ proxyRelacionamento.valor1 }}"
                                            >
                                            {{ proxyRelacionamento.valor1 }}
                                        </span><br />
                                        
                                    </td>
                                    <td class="border-none">
                                        <span 
                                            v-if="proxyRelacionamento.descricaoverba1.substring(0, 1) == 'D'"
                                            >
                                            {{ proxyRelacionamento.valor1 }}
                                        </span><br />
                                    </td>
                                </tr>
                            </thead>
                        </table>

                        <table class="w-full">
                            <thead class="thead-descricao-valor">
                                <tr>
                                    <td class="border-y-0 border-r-0">
                                        <span> </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-II"
                                        style="border: none"
                                    >
                                        <span> </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-III"
                                        style="border: none"
                                    >
                                        <span> </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-IV"
                                        style="border-bottom: 1px solid #000"
                                    >
                                        <span
                                            style="
                                                font-size: 10px;
                                                text-align: center;
                                            "
                                            >Total de Vencimentos</span
                                        >
                                    </td>
                                    <td
                                        class="td-descricao-valor-V"
                                        style="border-bottom: 1px solid #000"
                                    >
                                        <span
                                            style="
                                                font-size: 10px;
                                                text-align: center;
                                            "
                                            >Total de Descontos</span
                                        >
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-y-0 border-r-0">
                                        <span></span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-II"
                                        style="border: none"
                                    >
                                        <span> </span>
                                    </td>
                                    <td class="pr-[182px]" style="border: none">
                                        <span>  </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-IV"
                                        style="border-bottom: 1px solid #000"
                                    >
                                        <span> {{ totalSomaC }} </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-V"
                                        style="border-bottom: 1px solid #000"
                                    >
                                        <span>{{ totalSomaD }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-y-0 border-r-0">
                                        <span> </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-II"
                                        style="border: none"
                                    >
                                        <span> </span>
                                    </td>
                                    <td
                                        class="td-descricao-valor-III"
                                        style="border: none"
                                    >
                                        <span> </span>
                                    </td>
                                    <td class="td-descricao-valor-IV">
                                        <b><span>Valor Liq. R$</span></b>
                                    </td>
                                    <td class="td-descricao-valor-V">
                                        <b><span>{{ totalSomaC-totalSomaD }}</span></b>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <table class="w-full">
                            <thead class="">
                                <tr>
                                    <td class="border-b-0 text-center">
                                        <span>Salário Base</span>
                                    </td>
                                    <td class="border-b-0 text-center">
                                        <span>Salário Contr. INSS</span>
                                    </td>
                                    <td class="border-b-0 text-center">
                                        <span>Base FGTS</span>
                                    </td>
                                    <td class="border-b-0 text-center">
                                        <span>FGTS do Mês</span>
                                    </td>
                                    <td class="border-b-0 text-center">
                                        <span>Base Calc. IRRF</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-t-0 text-center">
                                        <span>{{ dataValorsalariobase }}</span>
                                    </td>
                                    <td class="border-t-0 text-center">
                                        <span>{{ dataValorBaseINNS }}</span>
                                    </td>
                                    <td class="border-t-0 text-center">
                                        <span>{{ dataValorBaseFGTS }}</span>
                                    </td>
                                    <td class="border-t-0 text-center">
                                        <span>{{ dataValorFGTS }}</span>
                                    </td>
                                    <td class="border-t-0 text-center">
                                        <span> {{ dataValorBaseIRRF }}</span>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <table class="w-full">
                            <thead class="thead-funcionario">
                                <tr>
                                    <td
                                        class="border-b-0 text-center"
                                        colspan="2"
                                    >
                                        <span
                                            >Declaro ter recebido a importância
                                            liquida discriminada neste
                                            recibo</span
                                        >
                                    </td>
                                </tr>

                                <tr>
                                    <td
                                        class="border-b-0 border-t-0 border-r-0 text-center"
                                    >
                                        <span><u><i>{{ dataAssinautra }}</i></u></span>
                                    </td>
                                    <td
                                        class="border-b-0 border-t-0 border-l-0 text-center"
                                    >
                                        <span><u><i>{{ dataFuncionario[1] }}</i></u></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        class="border-t-0 border-r-0 text-center"
                                    >
                                        <span>DATA</span>
                                    </td>
                                    <td
                                        class="border-t-0 border-l-0 text-center"
                                    >
                                        <span>ASSINATURA DO FUNCIONÁRIO</span>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
               
            </div>
        </div>
    </AppLayout>
</template>

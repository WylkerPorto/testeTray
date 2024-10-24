<template>
  <div v-if="sellerDetails">
    <p>Vendedor: {{ sellerDetails?.name }}</p>
    <p>Email: {{ sellerDetails?.email }}</p>
    <p>
      Cadastrado: {{ moment(sellerDetails?.created_at).format("DD/MM/YYYY") }}
    </p>
  </div>

  <section>
    <table>
      <thead>
        <tr>
          <th>Data</th>
          <th>Venda</th>
          <th>Comissão</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sale in sales" :key="sale.uid">
          <td>{{ moment(sale.sale_date).format("DD/MM/YYYY") }}</td>
          <td>R$: {{ sale.value }}</td>
          <td>R$: {{ (sale.value * 0.085).toFixed(2) }}</td>
        </tr>
        <tr>
          <td>Totais</td>
          <td>
            R$:
            {{
              sales
                .reduce((a: number, b: any) => a + Number(b.value), 0)
                .toFixed(2)
            }}
          </td>
          <td>
            R$:
            {{
              sales
                .reduce((a: number, b: any) => a + Number(b.value * 0.085), 0)
                .toFixed(2)
            }}
          </td>
        </tr>
      </tbody>
    </table>
  </section>
</template>
<script lang="ts">
import saleService from "@/services/saleService";
import moment from "moment";

interface ISale {
  uid: string;
  sale_date: string;
  value: number;
  seller: {
    name: string;
    email: string;
    created_at: string;
  };
}

export default {
  name: "ListSalesReportTable",
  data() {
    return {
      moment,
      sales: [] as ISale[],
    };
  },
  mounted() {
    if (this?.$route?.params?.id) {
      this.getSaleBySeller(this.$route.params.id.toString());
    }
  },

  methods: {
    async getSaleBySeller(id: string) {
      try {
        this.sales = await saleService.getSalesBySeller(id);
      } catch (e) {
        console.log("error", e);
      }
    },
  },
  computed: {
    sellerDetails() {
      if (this.$route?.params?.id) {
        // retorna o primeiro campo para exibir o nome do vendedor
        return this.sales[0]?.seller;
      }
    },
  },
};
</script>
<style lang="scss" scoped>
div {
  @apply flex flex-wrap justify-between gap-2 text-xl mb-5;
}

section {
  @apply block;
  max-height: 700px;

  table {
    @apply table-auto w-full;

    thead {
      @apply sticky -top-8 bg-slate-50;

      tr {
        @apply border-b;

        th {
          @apply p-4;
        }
      }
    }

    tbody {
      @apply overflow-y-auto;

      tr {
        @apply odd:bg-white even:bg-gray-50 border-b text-center;

        td {
          @apply p-4;
        }
      }
    }
  }
}
</style>

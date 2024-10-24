<template>
  <div v-if="sellerDetails">
    <p>Vendedor: {{ sellerDetails?.name }}</p>
    <p>Email: {{ sellerDetails?.email }}</p>
    <p>
      Cadastrado: {{ moment(sellerDetails?.created_at).format("DD/MM/YYYY") }}
    </p>
  </div>

  <form @submit.prevent="getSaleBySeller">
    <div>
      <label for="sale_date">Consultar vendas do dia</label>
      <input
        type="date"
        name="sale_date"
        id="sale_date"
        v-model="data_search"
      />
    </div>
    <button type="submit">Consultar</button>
  </form>

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
          <td>R$: {{ (Number(sale.value) * 0.085).toFixed(2) }}</td>
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
import type { ISale } from "@/interfaces/ISale";

export default {
  name: "ListSalesReportTable",
  data() {
    return {
      moment,
      sales: [] as ISale[],
      data_search: moment().format("YYYY-MM-DD"),
      rota: this.$route.params.id.toString(),
    };
  },
  mounted() {
    if (this?.$route?.params?.id) {
      this.getSaleBySeller();
    }
  },

  methods: {
    async getSaleBySeller() {
      try {
        this.sales = await saleService.getSalesBySeller(
          this.rota,
          this.data_search
        );
      } catch (e) {
        console.log("error", e);
      }
    },
  },
  computed: {
    sellerDetails() {
      if (this.sales) {
        // retorna o primeiro campo para exibir o nome do vendedor
        return this.sales[0]?.seller;
      }
    },
  },
};
</script>
<style lang="scss" scoped>
div:has(p) {
  @apply flex flex-wrap justify-between gap-2 text-xl mb-5;
}

form {
  @apply flex justify-between gap-2 mb-3;

  div {
    @apply flex flex-col;

    input {
      @apply outline-none pl-4 text-lg border border-gray-300;
    }
  }

  button {
    @apply border border-gray-300 rounded-2xl px-4;
  }
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

import { Bar } from 'react-chartjs-2'
import { IGeralAnoBar } from '../../../types/financa'

export default function GeralAnoBar(props: IGeralAnoBar) {

  const meses = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
  ]

  return (!props.values)
    ? null
    : (
      <Bar
        data={{
          // labels: props.labels,
          labels: meses,
          datasets: [
            {
              data: props.values.map(v => +v) || [],
              backgroundColor: ['#adb5bd', '#dee2e6'],
              borderColor: ['#6c757d'],
              borderWidth: 1,
              hoverOffset: 2
            }
          ]
        }}
        options={{
          animation: false,
          plugins: {
            legend: {
              display: false,
            },
            title: {
              display: false
            }
          },
        }}
      />
    )
}

import { Pie } from 'react-chartjs-2'
import { IGraficoDashboardPie } from '../../../types/financa'

export default function DashboardPie(props: IGraficoDashboardPie) {

  return (!props.labels && !props.labels)
    ? null
    : (
      <Pie
        width={100}
        height={100}
        data={{
          labels: props.labels,
          datasets: [
            {
              label: false,
              data: props.values || [],
              backgroundColor: ['#adb5bd', '#dee2e6'],
              borderColor: ['#6c757d'],
              borderWidth: 1,
              hoverOffset: 2
            }
          ]
        }}
        options={{
          // animation: false,
          plugins: {
            title: {
              display: false,
              text: props.title || 'Custom Chart Title',
              padding: 0,
              font: {
                size: 18
              }
            }
          },
        }}
      />
    )
}

import { Pie } from 'react-chartjs-2'
import { IGraficoProps } from '../../../types/financa'

export default function DashboardPie(props: IGraficoProps) {

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
            }
          ]
        }}
        options={{
          // animation: false,
          plugins: {
            title: {
              display: !!props?.title,
              text: props?.title,
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

/**
 * Created by imsun on 2015/7/14.
 */
'use strict'

let echarts = require('echarts')
require('echarts/chart/map')

let optionTemplate = {
  title: {
    text: '24 小时访问量',
    subtext: 'baixing.com',
    x: 'center'
  },
  tooltip: {
    trigger: 'item'
  },
  toolbox: {
    show: true,
    orient: 'vertical',
    x: 'right',
    y: 'center',
    feature: {
      mark: {show: true},
      dataView: {show: true, readOnly: false},
      restore: {show: true},
      saveAsImage: {show: true}
    }
  },
  roamController: {
   show: true,
   x: 'right',
   mapTypeControl: {
     'china': true
   }
  },
  dataRange: {
    text:['峰值', '低'],           // 文本，默认为数值文本
    calculable : true,
    x: 'left',
    min: 0,
    max: 1000
  },
  series: []
}

class Option {
  constructor(data) {
    let self = this
    Object.assign(this, optionTemplate, {
      dataRange: {
       text:['峰值', '低'],           // 文本，默认为数值文本
       calculable : true,
       x: 'left',
       min: 0,
       get max() {
         return  Math.max.apply(null, self.series.map((dataSeries) => {
           return Math.max.apply(null, dataSeries.data.map((row) => {
             return row.value
           }))
         }))
       }
      },
      series: [{
        name: 'PV',
        type: 'map',
        mapType: 'china',
        roam: false,
        itemStyle: {
          normal: {label: {show: true}},
          emphasis: {label: {show: true}}
        },
        data
      }]
    })
  }
}
let defaultOption = {
  timeline: {
    data: [],
    label: {
      formatter: function(s) {
        return parseInt(s.slice(2, 4), 10) + ' 时'
      }
    },
    autoPlay: false,
    playInterval : 1000
  }
}

export class BxMap {
  constructor(option = {}) {
    this.option = {}
    Object.assign(this.option, defaultOption, option)
  }
  init(domElement) {
    this.chart = echarts.init(domElement)
    this.update()
  }
  update() {
    let httpRequest = new XMLHttpRequest()
    httpRequest.onreadystatechange = () => {
      if (httpRequest.readyState === 4) {
        if (httpRequest.status === 200) {
          this.setData(JSON.parse(httpRequest.responseText).data)
        } else {}
      } else {}
    }
    httpRequest.open('GET', 'http://192.168.100.54/json.php', true)
    httpRequest.send()
  }
  setData(data) {
    this.option.timeline.data = data.map(item => '20' + (item.time < 10 ? '0' + item.time : item.time) + '-01-01')
    this.option.options = data.map(item => new Option(item.data))
    this.setOption()
  }
  setOption(option = {}) {
    Object.assign(this.option, option)
    if (this.chart) this.chart.setOption(this.option)
  }
}

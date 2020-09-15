/* eslint-disable no-prototype-builtins */
Date.prototype.getWeekOfMonth = function () {
  let month = this.getMonth()
  let firstWeekday = new Date(this.getFullYear(), month, 1).getDay()
  let offsetDate = this.getDate() + firstWeekday - 1
  let week = 1 + Math.floor(offsetDate / 7) // remove the 1 + if you want to be 0-based
  let weekInMilliseconds = 7 * 24 * 60 * 60 * 1000
  // eslint-disable-next-line prettier/prettier
  let num = week === 4 ? week + (month !== new Date(this.getTime() + weekInMilliseconds).getMonth()) : week
  let ord = {
    1: 'st',
    2: 'nd',
    3: 'rd',
    4: 'th',
    5: 'th',
  }

  return num + ord[num]
}

let RRuleField = (function ($) {
  let self = {},
    parts,
    $repeatsCheck,
    $rule,
    $freq,
    $bydays,
    $repeatby,
    $interval,
    $until,
    $untilDate,
    $summary,
    freqEvents,
    $intervalLabel,
    intervalLabels,
    dayLabels,
    startDate

  self.init = function () {
    self.assignletiables()
    self.bindUI()

    if ($rule.val() !== '') {
      $('.control-fields').show()
      $repeatsCheck.prop('checked', true)
      self.populateFromRuleString($rule.val())
      self.updateSummary()
    } else {
      self.reset()
    }
  }

  self.assignletiables = function () {
    parts = {
      FREQ: '',
      INTERVAL: '',
      BYDAY: '',
      BYMONTHDAY: '',
      UNTIL: '',
    }
    $repeatsCheck = $('input[name=IsRecurring]')
    $rule = $('input[name=RRule]')
    $freq = $('input[name=frequency]')
    $bydays = $('input[name=byday]')
    $repeatby = $('input[name=repeatby]')
    $interval = $('select[name=interval]')
    $until = $('input[name=until]')
    $untilDate = $('.until-date')
    $summary = $('.rrule-summary')
    freqEvents = {
      DAILY: 'freqdaily',
      WEEKLY: 'freqweekly',
      MONTHLY: 'freqmonthly',
    }
    $intervalLabel = $('.interval-label')
    intervalLabels = {
      '': '',
      DAILY: 'days',
      WEEKLY: 'weeks',
      MONTHLY: 'months',
      YEARLY: 'years',
    }
    dayLabels = {
      SU: 'Sunday',
      MO: 'Monday',
      TU: 'Tuesday',
      WE: 'Wednesday',
      TH: 'Thursday',
      FR: 'Friday',
      SA: 'Saturday',
    }
    // eslint-disable-next-line no-unused-vars
    startDate = new Date($('#Form_ItemEditForm_Start-date').val())
  }

  self.bindUI = function () {
    $repeatsCheck.on('click', function () {
      if (!$(this).is(':checked')) {
        self.reset()
        $('.control-fields').hide()
      } else {
        $('.control-fields').show()
        self.populateRuleString()
        self.updateSummary()
      }
    })

    $rule.on('freqchange', function (e, interval) {
      parts['FREQ'] = interval
      $intervalLabel.text(intervalLabels[interval])
      $rule.trigger('rulechange')
    })

    $rule.on('freqdaily', function () {
      $rule.trigger('freqchange', 'DAILY')
    })

    $rule.on('freqweekly', function () {
      $rule.trigger('freqchange', 'WEEKLY')
      $('.bydays-wrapper').show()
    })

    $rule.on('freqmonthly', function () {
      $rule.trigger('freqchange', 'MONTHLY')
      $('.repeatby-wrapper').show()
    })

    $rule.on('freqdaily freqmonthly', function () {
      self.resetBydays()
    })

    $rule.on('freqdaily freqweekly', function () {
      self.resetRepeatBy()
    })

    $freq.on('click', function () {
      $rule.trigger(freqEvents[$(this).val()])
    })

    $interval.on('change', function () {
      parts['INTERVAL'] = $(this).val()
      $rule.trigger('rulechange')
    })

    $bydays.on('click', function () {
      parts['BYDAY'] = $bydays
        .map(function () {
          if ($(this).is(':checked')) return $(this).val()
        })
        .get()
        .join(',')

      $rule.trigger('rulechange')
    })

    $until.on('click', function () {
      if ($(this).val() === 'never') {
        self.resetUntil()
      }

      $rule.trigger('rulechange')
    })

    $untilDate.flatpickr({
      dateFormat: 'Ymd',
      minDate: new Date(),
      onChange: function (_, dateStr) {
        if (dateStr === '') {
          self.resetUntil()
        } else {
          $('input[name=until][value=date]').prop('checked', true)
          parts['UNTIL'] = dateStr
        }

        $rule.trigger('rulechange')
      },
    })

    $rule.on('rulechange', function () {
      self.populateRuleString()
      self.updateSummary()
    })
  }

  self.reset = function () {
    $rule.val('')
    $summary.text('').hide()
    $freq.prop('checked', false).first().prop('checked', true)
    self.resetBydays()
    self.resetRepeatBy()
    self.resetInterval()
    self.resetUntil()
    parts['FREQ'] = 'DAILY'
    parts['INTERVAL'] = '1'
  }

  self.resetBydays = function () {
    $bydays.prop('checked', false)
    parts['BYDAY'] = ''
    $('.bydays-wrapper').hide()
  }

  self.resetInterval = function () {
    $interval.val('1')
    parts['INTERVAL'] = '1'
    $intervalLabel.text('days')
  }

  self.resetRepeatBy = function () {
    $repeatby.prop('checked', false).first().prop('checked', true)
    parts['BYMONTHDAY'] = ''
    $('.repeatby-wrapper').hide()
  }

  self.resetUntil = function () {
    $until.prop('checked', false).first().prop('checked', true)
    $untilDate.val('')
    parts['UNTIL'] = ''
  }

  self.populateFromRuleString = function (rule) {
    parts = self.ruleStringToParts(rule)
    self.populateFrequency(parts['FREQ'])
    self.populateInterval(parts['INTERVAL'])
    self.populateByday(parts['BYDAY'])
    self.populateUntil(parts['UNTIL'])
  }

  self.populateFrequency = function (val) {
    $('input:radio[name=frequency][value=' + val + ']').prop('checked', true)
    $rule.trigger(freqEvents[val])
  }

  self.populateInterval = function (val) {
    $('select[name=interval]').val(val)
  }

  self.populateByday = function (val) {
    let days = val.split(',')
    for (let d in days) {
      $('input[name=byday][value=' + days[d] + ']').prop('checked', true)
    }
  }

  self.populateUntil = function (val) {
    if (val === '') {
      $('input[name=until][value=never]').prop('checked', true)
    } else {
      $('input[name=until][value=date]').prop('checked', true)
      $untilDate.val(val)
    }
  }

  self.ruleStringToParts = function (rule) {
    return {
      FREQ: self.rmatch(rule, /FREQ=(YEARLY|MONTHLY|WEEKLY|DAILY)/),
      INTERVAL: self.rmatch(rule, /INTERVAL=(\d+)/, 1) * 1,
      BYDAY: self.rmatch(rule, /BYDAY=([+0-9A-Z,]+)/),
      BYMONTHDAY: self.rmatch(rule, /BYMONTHDAY=([\d,]+)/),
      UNTIL: self.rmatch(rule, /UNTIL=(\d+)/),
    }
  }

  self.rmatch = function (value, regex, empty) {
    if (empty === undefined) empty = ''
    let result = value.match(regex)
    return result && result[1] ? result[1] : empty
  }

  self.populateRuleString = function () {
    let rule = []
    if (parts['FREQ'] === '') return ''
    for (let p in parts) {
      if (parts.hasOwnProperty(p) && parts[p] !== '')
        rule.push(p + '=' + parts[p])
    }

    $rule.val(rule.join(''))
  }

  self.updateSummary = function () {
    let summary = 'Repeat every {interval} {freq} {byday} {until}'

    let freq = parts['FREQ']
    let interval = parts['INTERVAL']
    let bydays = parts['BYDAY']
    let until = parts['UNTIL']

    $summary.text('').hide()

    if (bydays) {
      bydays = $.map(bydays.split(','), function (el) {
        return dayLabels[el]
      })
    }

    freq = intervalLabels[freq]

    if (interval < 2) {
      freq = freq.substr(0, freq.length - 1)
      interval = ''
    }

    let untilText =
      // eslint-disable-next-line no-undef
      until === '' ? '' : 'until ' + moment(until, 'YYYYMMDD').calendar()

    summary = summary.replace('{interval}', interval)
    summary = summary.replace('{freq}', freq)
    // eslint-disable-next-line prettier/prettier
    summary = bydays && bydays.length ? summary.replace('{byday}', 'on ' + bydays.join(', ')) : summary.replace('{byday}', '')
    summary = summary.replace('{until}', untilText)

    $summary.text(summary)

    if (summary !== '') {
      $summary.show()
    }
  }

  return self
})(window.jQuery)(function ($) {
  $.entwine('ss', function ($) {
    $('#RRuleField').entwine({
      onmatch: RRuleField.init,
    })
  })
  // eslint-disable-next-line no-undef
})(jQuery)

timer:
    %local table_report; %let table_report = report;
    %local table_add; %let table_add = add_to_report;

    new:
        %&self(set, steps, );
		%&self(set, steps_num, 0);
        %&self(start_total);
		%global &this._finish_total_done; %let &this._finish_total_done = 0;

    
    set(varname, value):
        %global &this._&varname; 
        %let &this._&varname = &value;
        
    get(varname):
        &&&this._&varname
        
    set_now(varname):
        %global &this._&varname;
        %let &this._&varname = %sysfunc(datetime());
        
    start(step_name):
        %if not(%symexist(&this._steps)) %then %&self(new);
		%else %if &&&this._steps = __empty__ %then %&self(new);
        %else %&self(finish_step);
        %let &this._steps = &&&this._steps %str(;) &step_name;
		%let &this._steps_num = %eval(&&&this._steps_num + 1);
        %&self(set_now, start_&&&this._steps_num);
        %put ********* START &step_name *********;
        
    finish_step:
        %&self(set_now, finish_&&&this._steps_num);
        
    start_total:
        %&self(set_now, total_start);
        
    finish_total:
        %local total;
        %&self(finish_step);
        %let total = %sysevalf(%sysfunc(datetime()) - &&&this._total_start);
        %&self(set, total_duration, &total);
		%let &this._finish_total_done = 1;
        
    init_report:
        proc format;
            picture pct
            low-high = '009.99%';
        run;
        data &table_report;
            informat name $255. duration $255. percent $255.;
            name = "temp";
            duration = "temp";
            percent = "temp";
            output;
        run;
        data &table_report;
            modify &table_report;
            remove; 
        run;
        
    add_log(name, duration, percent):
        data &table_add;
            informat name $255. duration $255. percent $255.;
            name = "&name";
            duration = "&duration";
            percent = "&percent";
            output;
        run;
        proc append 
            base = &table_report
            data = &table_add
            force;
        run;
        
    add_duration(step_num):
        %local total start finish duration percent;
        %let total = &&&this._total_duration;
        %let start = &&&this._start_&step_num;
        %let finish = &&&this._finish_&step_num;
        %let duration = %sysevalf(&finish - &start);
        %let percent = %sysfunc(round(&duration / &total * 100, 0.01));
        %&self(add_log, %scan(&&&this._steps, &step_num, %str(;)), 
            %sysfunc(putn(&duration, time13.2)), 
            %sysfunc(putn(&percent, pct.))
        )
        
    add_all_duration:
        %local i;
        %do i=1 %to &&&this._steps_num;
            %&self(add_duration, &i);
        %end;
        
    add_total_duration:
        %&self(add_log, Total, 
            %sysfunc(putn(&&&this._total_duration, time13.2)), 
            %sysfunc(putn(100, pct.))
        )
        
    print_all_duration(title):
        title &title;
        proc print data = &table_report double NOOBS SPLIT = "";
            label name = Etape;
            label duration = Durée;
            label percent = %;
            var name duration percent; 
        run;
        proc datasets nolist;
           delete &table_add &table_report;
        run;
        
    print(title):
		%if "&title" = "" %then %let title = Durée des étapes;
		%if not(&&&this._finish_total_done) %then
			%&self(finish_total);
        %&self(init_report);
        %&self(add_all_duration);
        %&self(add_total_duration);
        %&self(print_all_duration, &title);
        %let &this._steps = __empty__;

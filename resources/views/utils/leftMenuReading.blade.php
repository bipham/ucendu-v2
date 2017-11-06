<?php
/**
 * Created by PhpStorm.
 * User: BiPham
 * Date: 9/27/2017
 * Time: 11:40 PM
 */
?>

<div class="nav-left-menu transform-custom">
    <div class="menu-list">
        <?php
        $readingTypeQuestionService = new App\Services\ReadingTypeQuestionService();
        $readingLessonService = new App\Services\ReadingLessonService();
        $readingLearningTypeQuestionService = new App\Services\ReadingLearningTypeQuestionService();
        $readingLevelLessonService = new App\Services\ReadingLevelLessonService();
        $readingStatusLearningOfUserService = new App\Services\ReadingStatusLearningOfUserService();
        $readingResultService = new App\Services\ReadingResultService();
        $all_level_lessons = $readingLevelLessonService->getAllLevelLesson();
        $current_level_lesson = $readingLevelLessonService->getLevelLessonById($level_lesson_id);
        $all_lessons = $readingTypeQuestionService->getAllTypeQuestionById($level_lesson_id);
//        dd($all_lessons);
        ?>
        <div class="header-left-menu">
            <div class="center-class logo-website-left-menu">
                <a href="{{url('/')}}" class="brand-web">
                    <img src="{{url('/public/imgs/original/logo.jpg')}}" alt="Logo" class="img-custom img-logo-website">
                </a>
            </div>
        </div>
        <div class="body-left-menu">
            <div class="top-menu">
                <h3 class="level-lesson-current">
                    <a href="{{url('/reading/'. $current_level_lesson->id . '-level/')}}">
                        {!! $current_level_lesson->level !!}
                    </a>
                </h3>
                <div class="dropdown list-level-lesson">
                    <span class="fa-stack fa-lg select-level-lesson" data-toggle="dropdown">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-caret-right fa-stack-1x icon-inner-custom icon-hide"></i>
                        <i class="fa fa-caret-down fa-stack-1x icon-inner-custom icon-show"></i>
                    </span>
                    <div class="dropdown-menu">
                        @foreach($all_level_lessons as $level_lesson)
                            <a href="{{url('/reading/'. $level_lesson->id . '-level/')}}" class="dropdown-item @if($level_lesson->id == $current_level_lesson->id) disabled @endif">{!! $level_lesson->level !!}</a>
                        @endforeach
                            <div class="dropdown-divider"></div>
                            <h6 class="dropdown-header">Select Level</h6>
                    </div>
                </div>
            </div>
            <ul id="menu-content" class="menu-content">
                <h6 class="title-menu">
                    Lessons
                </h6>
                @foreach($all_lessons as $key_lesson => $lesson)
                    <li  data-toggle="collapse" data-target="#lesson-{!! $lesson->id !!}" class="collapsed level-one" aria-expanded="@if($lesson->id == $type_question_id_current) true @else false @endif">
                        <a href="#">{!! $key_lesson + 1 !!}. {!! $lesson->name !!} <span class="arrow"></span></a>
                    </li>
                    <ul class="sub-menu sub-level-one collapse @if($lesson->id == $type_question_id_current) show @endif" id="lesson-{!! $lesson->id !!}">
                        {{--Show learning:--}}
                        <li data-toggle="collapse" data-target="#learning-{!! $lesson->id !!}" class="collapsed level-two" aria-expanded="@if(config('constants.type_lesson.learning') == $type_lesson_id) true @else false @endif">
                            <a href="#">
                                <i class="fa fa-leanpub icon-head-title-custom" aria-hidden="true"></i>
                                Learning
                            </a>
                        </li>
                        <ul class="sub-menu sub-level-two collapse @if(config('constants.type_lesson.learning') == $type_lesson_id) show type-current @endif" id="learning-{!! $lesson->id !!}">
                            <?php
                            $all_learnings = $readingLearningTypeQuestionService->getLearningOfTypeQuestion($lesson->id);
                            ?>
                            @foreach($all_learnings as $learning)
                                <li>{!! $learning->title_section !!}</li>
                            @endforeach
                        </ul>

                        {{--Show practice:--}}
                        <li data-toggle="collapse" data-target="#practice-{!! $lesson->id !!}" class="collapsed level-two" aria-expanded="@if(config('constants.type_lesson.practice') == $type_lesson_id) true @else false @endif">
                            <a href="#">
                                <i class="fa fa-pencil icon-head-title-custom" aria-hidden="true"></i>
                                Practices
                            </a>
                        </li>
                        <ul class="sub-menu sub-level-two collapse @if(config('constants.type_lesson.practice') == $type_lesson_id) show type-current @endif" id="practice-{!! $lesson->id !!}">
                            <?php
                            $all_practices = $readingLessonService->getLessonsByTypeQuestionId(Config('constants.type_lesson.practice'), $lesson->id);
                            $highest_step = $readingStatusLearningOfUserService->getHighestStepLessonService($current_level_lesson->id, $lesson->id, config('constants.type_lesson.practice'));
                            ?>
                            @foreach($all_practices as $practice)
                                 <?php
                                    $check_vip = $readingLessonService->checkVipLesson(config('constants.type_lesson.practice'), $practice->id);
                                    $highest_score = $readingResultService->getHighestScoreLesson(config('constants.type_lesson.practice'), $practice->id);
                                 ?>
                                <li class="item-lesson @if($practice->id == $lesson_id_current) current-step @endif @if($practice->order_lesson > $highest_step) disabled-lesson @endif">
                                    @if($check_vip)
                                        <span class="pull-left title-lesson-menu">
                                            {!! $practice->title !!}
                                        </span>
                                        <span class="pull-right tools-area-menu">
                                            <a href="#" class="badge badge-pill badge-danger link-upgrade-user">
                                                VIP
                                            </a>
                                        </span>
                                    @elseif($practice->order_lesson > $highest_step)
                                        <span class="pull-left title-lesson-menu">
                                            {!! $practice->title !!}
                                        </span>
                                        <span class="pull-right tools-area-menu">
                                            <i class="fa fa-lock" aria-hidden="true"></i>
                                        </span>
                                    @else
                                        <span class="pull-left title-lesson-menu">
                                            <a href="{{url('/reading/' . $level_lesson_id . '-level/readingLesson/' . config('constants.type_lesson.practice') . '-practice/' . $practice->id . '-practice-1')}}">
                                                {!! $practice->title !!}
                                            </a>
                                        </span>
                                        <span class="pull-right tools-area-menu">
                                            <a href="{{url('/reading/'. $current_level_lesson->id . '-level/readingViewSolutionLesson/' . config('constants.type_lesson.practice')  . 'practice-' . $practice->id . $practice->title)}}" class="badge badge-success link-solution-lesson">
                                                <i class="fa fa-key" aria-hidden="true"></i> Solution
                                            </a>
                                            @if($highest_score == null)
                                                <i class="fa fa-unlock" aria-hidden="true"></i>
                                            @else
                                                <span class="badge badge-primary">{!! $highest_score->highest_correct !!}/{!! $practice->total_questions !!}</span>
                                            @endif
                                        </span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </ul>
                @endforeach
            </ul>
        </div>
    </div>
</div>